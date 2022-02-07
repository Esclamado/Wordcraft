<?php

namespace App;

use App\Product;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Auth;
use App\AffiliateUser;

use Mail;
use App\Mail\EmailManager;

use Hash;

class EmployeeImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model (array $row)
    {
        $role = \App\Role::where('name', 'Employee')
            ->first();

        $password = Str::random(8);

        $user = new User([
            'unique_id' => unique_code(9),
            'name' => $row['first_name'] . ' ' . $row['last_name'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'employee_id' => $row['employee_id'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'password' => Hash::make($password),
            'user_type' => 'employee',
            'email_verified_at' => \Carbon\Carbon::now(),
        ]);

        $user->referral_code = substr($user->id . Str::random(), 0, 10);
        $user->save();

        $affiliate_user = new AffiliateUser;

        $affiliate_user->user_id = $user->id;
        $affiliate_user->status = 1;
        $affiliate_user->save();

        $staff = new \App\Staff;

        $staff->user_id = $user->id;
        $staff->role_id = $role->id;

        if ($staff->save()) {
            $array['view'] = 'emails.newsletter';
            $array['subject'] = 'Worldcraft Employee Account';
            $array['from'] = env('MAIL_USERNAME');
            $array['content'] = "
                <html>
                    <body>
                        <h3>Hello!</h3>
                        <br />
                        <p>Worldcraft PH has created you an employee account. The following information is for your eyes only.</p>
                        <br />
                        <ul>
                            <li>Employee ID: <b>$user->employee_id</b></li>
                            <li>Email: <b>$user->email</b></li>
                            <li>Password: <b>$password</b></li>
                        </ul>
                        <br />
                        <p>If you have any concerns you can contact the management.</p>
                        <br />
                        <p>Thank you!</p>
                    </body>
                </html>
            ";

            try {
                Mail::to($user->email)->queue(new EmailManager($array));
            }

            catch (\Exception $e) {
                \Log::error($e);    
            }
        }
    }

    public function rules(): array
    {
        return [
            'employee_id' => 'required|unique:users,employee_id',
            'email' => 'required|unique:users,email'
        ];
    }
}
