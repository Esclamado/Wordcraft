<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactUs;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;

        $contacts = ContactUs::distinct();

        if ($request->has('search')) {
            $sort_search = $request->search;

            $contacts = $contacts->where('full_name', 'like', '%' . $sort_search . '%')
                ->orWhere('contact_number', 'like', '%' . $sort_search . '%')
                ->orWhere('email_address', 'like', '%' . $sort_search . '%');
        }

        $contacts = $contacts->paginate(15);

        return view('backend.support.contacts.index', compact('contacts', 'sort_search'));
    }

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $message = [
            'full_name.required' => 'Please input your full name',
            'contact_number.required' => 'Please input your contact number',
            'email.required' => 'Please input your email address',
            'message.required' => 'Please input your message for us'
        ];

        $this->validate($request, [
            'full_name' => 'required|max:30',
            'contact_number' => 'required|min:10|max:13',
            'email' => 'required|email|max:70',
            'message' => 'required'
        ], $message);

        $contact_us = new ContactUs;

        $contact_us->full_name = $request->full_name;
        $contact_us->contact_number = $request->contact_number;
        $contact_us->email_address = $request->email;
        $contact_us->message = $request->message;
        $contact_us->ip_address = request()->ip();

        $contact_us->save();

        flash(translate("Your message is successfully sent to us! We'll respond via your email or contact number. Thank you!"))->success();
        return redirect()->back();
    }

    /**
     * [mark_as_answered description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function mark_as_answered (Request $request) {
        $contact = ContactUs::findOrFail($request->el);

        $contact->answered = 1;

        if ($contact->save()) {
            return 1;
        }

        else {
            return 0;
        }
    }

    /**
     * [show description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function show($id) {
        $contact = ContactUs::findOrFail(decrypt($id));

        return view('backend.support.contacts.show', compact('contact'));
    }
}
