<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Notifications\SendProfileVerificationDocumentSubmittedNotification;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class CompanyVerifyDocuments extends Controller
{
    public function index()
    {
        try {
            $company = auth()->user()->company->load('media');

            return view('frontend.pages.company.verify-documents', [
                'company' => $company,
            ]);
        } catch (\Exception $e) {

            flashError('An error occurred: '.$e->getMessage());

            return back();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    // used for add new company and validate the request data
    public function store(Request $request)
    {
        try {
            // validation permission
            $company = auth()->user()->company->load('media');
            $request->validate([
                'document' => 'required|image|max:2000',
            ]);
            $company
                ->addMedia($request->file('document'))
                ->toMediaCollection('document');

            // this line is commented because we are not have mail service
            // send notification to admins
//            $adminRole = Role::query()->where('name', 'superadmin')->first();

//            $adminRole->users->each(function ($admin) use ($company) {
//                $admin->notify(new SendProfileVerificationDocumentSubmittedNotification($company));
//            });

            flashSuccess(__('document_uploaded_success'));

            return redirect()->back();
        } catch (\Exception $e) {

            flashError('An error occurred: '.$e->getMessage());

            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
