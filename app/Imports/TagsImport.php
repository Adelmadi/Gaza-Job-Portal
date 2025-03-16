<?php

namespace App\Imports;

use App\Models\Tag;
use App\Models\TagTranslation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Language\Entities\Language;

class TagsImport implements ShouldQueue, ToCollection, WithChunkReading, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // الحصول على جميع اللغات المتاحة
        $app_language = Language::latest()->get(['code', 'name']);

        foreach ($rows as $row) {
            // تحقق مما إذا كان الاسم العربي أو الإنجليزي موجودًا
            $existingTag = TagTranslation::where('name', $row['name_ar'])
                ->orWhere('name', $row['name_en'])
                ->exists();

            if (!$existingTag) {
                // إنشاء التاج الجديد
                $tag = Tag::create();

                // إضافة الترجمة باللغات المختلفة
                foreach ($app_language as $language) {
                    // الحصول على الاسم بناءً على اللغة
                    $name = null;
                    if ($language->code === 'ar') {
                        $name = $row['name_ar']; // الاسم بالعربي
                    } elseif ($language->code === 'en') {
                        $name = $row['name_en']; // الاسم بالإنجليزي
                    }

                    // تحقق من أن الاسم غير فارغ
                    if (!empty($name)) {
                        TagTranslation::create([
                            'tag_id' => $tag->id,
                            'name' => $name,
                            'locale' => $language->code,
                        ]);
                    } else {
                        // يمكنك التعامل مع حالة الاسم الفارغ هنا، مثلاً:
                        // إما تسجيل خطأ أو تجاهل الإدخال
                        // Log::warning("Empty name for tag ID {$tag->id} in locale {$language->code}");
                        continue;
                    }
                }
            } else {
                // يمكنك إضافة منطق لمعالجة حالة وجود التاج هنا إذا رغبت في ذلك
                continue;
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
