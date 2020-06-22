<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => '1',
                'title' => 'user_management_access',
            ],
            [
                'id'    => '2',
                'title' => 'permission_create',
            ],
            [
                'id'    => '3',
                'title' => 'permission_edit',
            ],
            [
                'id'    => '4',
                'title' => 'permission_show',
            ],
            [
                'id'    => '5',
                'title' => 'permission_delete',
            ],
            [
                'id'    => '6',
                'title' => 'permission_access',
            ],
            [
                'id'    => '7',
                'title' => 'role_create',
            ],
            [
                'id'    => '8',
                'title' => 'role_edit',
            ],
            [
                'id'    => '9',
                'title' => 'role_show',
            ],
            [
                'id'    => '10',
                'title' => 'role_delete',
            ],
            [
                'id'    => '11',
                'title' => 'role_access',
            ],
            [
                'id'    => '12',
                'title' => 'user_create',
            ],
            [
                'id'    => '13',
                'title' => 'user_edit',
            ],
            [
                'id'    => '14',
                'title' => 'user_show',
            ],
            [
                'id'    => '15',
                'title' => 'user_delete',
            ],
            [
                'id'    => '16',
                'title' => 'user_access',
            ],
            [
                'id'    => '17',
                'title' => 'failed_login_create',
            ],
            [
                'id'    => '18',
                'title' => 'failed_login_edit',
            ],
            [
                'id'    => '19',
                'title' => 'failed_login_show',
            ],
            [
                'id'    => '20',
                'title' => 'failed_login_delete',
            ],
            [
                'id'    => '21',
                'title' => 'failed_login_access',
            ],
            [
                'id'    => '22',
                'title' => 'audit_log_show',
            ],
            [
                'id'    => '23',
                'title' => 'audit_log_access',
            ],
            [
                'id'    => '24',
                'title' => 'shareholder_create',
            ],
            [
                'id'    => '25',
                'title' => 'shareholder_edit',
            ],
            [
                'id'    => '26',
                'title' => 'shareholder_show',
            ],
            [
                'id'    => '27',
                'title' => 'shareholder_delete',
            ],
            [
                'id'    => '28',
                'title' => 'shareholder_access',
            ],
            [
                'id'    => '29',
                'title' => 'loan_request_create',
            ],
            [
                'id'    => '30',
                'title' => 'loan_request_edit',
            ],
            [
                'id'    => '31',
                'title' => 'loan_request_show',
            ],
            [
                'id'    => '32',
                'title' => 'loan_request_delete',
            ],
            [
                'id'    => '33',
                'title' => 'loan_request_access',
            ],
            [
                'id'    => '34',
                'title' => 'deposit_contract_create',
            ],
            [
                'id'    => '35',
                'title' => 'deposit_contract_edit',
            ],
            [
                'id'    => '36',
                'title' => 'deposit_contract_show',
            ],
            [
                'id'    => '37',
                'title' => 'deposit_contract_delete',
            ],
            [
                'id'    => '38',
                'title' => 'deposit_contract_access',
            ],
            [
                'id'    => '39',
                'title' => 'deposit_schedule_create',
            ],
            [
                'id'    => '40',
                'title' => 'deposit_schedule_edit',
            ],
            [
                'id'    => '41',
                'title' => 'deposit_schedule_show',
            ],
            [
                'id'    => '42',
                'title' => 'deposit_schedule_delete',
            ],
            [
                'id'    => '43',
                'title' => 'deposit_schedule_access',
            ],
            [
                'id'    => '44',
                'title' => 'deposit_access',
            ],
            [
                'id'    => '45',
                'title' => 'loan_access',
            ],
            [
                'id'    => '46',
                'title' => 'loan_contract_create',
            ],
            [
                'id'    => '47',
                'title' => 'loan_contract_edit',
            ],
            [
                'id'    => '48',
                'title' => 'loan_contract_show',
            ],
            [
                'id'    => '49',
                'title' => 'loan_contract_delete',
            ],
            [
                'id'    => '50',
                'title' => 'loan_contract_access',
            ],
            [
                'id'    => '51',
                'title' => 'loan_main_schedule_create',
            ],
            [
                'id'    => '52',
                'title' => 'loan_main_schedule_edit',
            ],
            [
                'id'    => '53',
                'title' => 'loan_main_schedule_show',
            ],
            [
                'id'    => '54',
                'title' => 'loan_main_schedule_delete',
            ],
            [
                'id'    => '55',
                'title' => 'loan_main_schedule_access',
            ],
            [
                'id'    => '56',
                'title' => 'loan_memfee_schedule_create',
            ],
            [
                'id'    => '57',
                'title' => 'loan_memfee_schedule_edit',
            ],
            [
                'id'    => '58',
                'title' => 'loan_memfee_schedule_show',
            ],
            [
                'id'    => '59',
                'title' => 'loan_memfee_schedule_delete',
            ],
            [
                'id'    => '60',
                'title' => 'loan_memfee_schedule_access',
            ],
            [
                'id'    => '61',
                'title' => 'post_create',
            ],
            [
                'id'    => '62',
                'title' => 'post_edit',
            ],
            [
                'id'    => '63',
                'title' => 'post_show',
            ],
            [
                'id'    => '64',
                'title' => 'post_delete',
            ],
            [
                'id'    => '65',
                'title' => 'post_access',
            ],
            [
                'id'    => '66',
                'title' => 'place_create',
            ],
            [
                'id'    => '67',
                'title' => 'place_edit',
            ],
            [
                'id'    => '68',
                'title' => 'place_show',
            ],
            [
                'id'    => '69',
                'title' => 'place_delete',
            ],
            [
                'id'    => '70',
                'title' => 'place_access',
            ],
            [
                'id'    => '71',
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
