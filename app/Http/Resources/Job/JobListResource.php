<?php

namespace App\Http\Resources\Job;

use Illuminate\Http\Resources\Json\JsonResource;

class JobListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $salary = $this->salary_mode == 'range' ? currencyAmountShort($this->min_salary).' - '.currencyAmountShort($this->max_salary).' '.currentCurrencyCode() : $this->custom_salary;

        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'job_details' => route('website.job.details', $this->slug),
            'company_name' => $this->company && $this->company->user ? $this->company->user->name : '',
            'company_logo' => $this->company->logo_url,
            'job_type' => $this->job_type->name,
            'job_role' => $this->role->id,
            'category' => $this->category->id,
            'country' => $this->country,
            'is_featured' => $this->featured,
            'is_highlighted' => $this->highlight,
            'deadline' => $this->deadline,
            'salary' => $salary,
            'salary_mode' => $this->salary_mode,
            'min_salary' => $this->min_salary,
            'max_salary' => $this->max_salary,
            'bookmarked' => $this->bookmarked,
            'allAppliedJobs_count' => $this->all_applied_jobs_count,
        ];
    }
}
