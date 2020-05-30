<?php

return [
    'userManagement'     => [
        'title'          => 'Сотрудники',
        'title_singular' => 'Сотрудники',
    ],
    'permission'         => [
        'title'          => 'Разрешения',
        'title_singular' => 'Разрешение',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Title',
            'title_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'role'               => [
        'title'          => 'Роли',
        'title_singular' => 'Роль',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'title'              => 'Title',
            'title_helper'       => '',
            'permissions'        => 'Permissions',
            'permissions_helper' => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
    'user'               => [
        'title'          => 'Сотрудники',
        'title_singular' => 'Сотрудник',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Name',
            'name_helper'              => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => '',
            'password'                 => 'Password',
            'password_helper'          => '',
            'roles'                    => 'Roles',
            'roles_helper'             => '',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
        ],
    ],
    'failedLogin'        => [
        'title'          => 'Failed Login',
        'title_singular' => 'Failed Login',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'ip_address'        => 'Ip Address',
            'ip_address_helper' => 'IP address',
            'phone'             => 'Phone',
            'phone_helper'      => 'Phone number',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
            'sms'               => 'Sms',
            'sms_helper'        => '',
        ],
    ],
    'auditLog'           => [
        'title'          => 'Audit Logs',
        'title_singular' => 'Audit Log',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => '',
            'description'         => 'Description',
            'description_helper'  => '',
            'subject_id'          => 'Subject ID',
            'subject_id_helper'   => '',
            'subject_type'        => 'Subject Type',
            'subject_type_helper' => '',
            'user_id'             => 'User ID',
            'user_id_helper'      => '',
            'properties'          => 'Properties',
            'properties_helper'   => '',
            'host'                => 'Host',
            'host_helper'         => '',
            'created_at'          => 'Created at',
            'created_at_helper'   => '',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => '',
        ],
    ],
    'shareholder'        => [
        'title'          => 'Shareholders',
        'title_singular' => 'Shareholder',
        'fields'         => [
            'id'                     => 'ID',
            'id_helper'              => '',
            'phone'                  => 'Phone',
            'phone_helper'           => 'Phone number',
            'password'               => 'Password',
            'password_helper'        => 'Password of client',
            'code'                   => 'Code',
            'code_helper'            => 'Code of sms',
            'sms_sended_at'          => 'Sms Sended At',
            'sms_sended_at_helper'   => '',
            'doc'                    => 'Doc',
            'doc_helper'             => '',
            'fio'                    => 'Fio',
            'fio_helper'             => 'Name of shareholder',
            'allow_request'          => 'Allow Request',
            'allow_request_helper'   => '',
            'created_at'             => 'Created at',
            'created_at_helper'      => '',
            'updated_at'             => 'Updated at',
            'updated_at_helper'      => '',
            'deleted_at'             => 'Deleted at',
            'deleted_at_helper'      => '',
            'code_expires_at'        => 'Code Expires At',
            'code_expires_at_helper' => '',
        ],
    ],
    'loanRequest'        => [
        'title'          => 'Loan Request',
        'title_singular' => 'Loan Request',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => '',
            'shareholder'         => 'Shareholder',
            'shareholder_helper'  => 'Related client',
            'request_no'          => 'Request No',
            'request_no_helper'   => 'Request number',
            'amount'              => 'Amount',
            'amount_helper'       => 'Amount',
            'status'              => 'Status',
            'status_helper'       => 'Status of request',
            'created_at'          => 'Created at',
            'created_at_helper'   => '',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => '',
            'deleted_at'          => 'Deleted at',
            'deleted_at_helper'   => '',
            'request_date'        => 'Request Date',
            'request_date_helper' => '',
        ],
    ],
    'depositContract'    => [
        'title'          => 'Deposit Contract',
        'title_singular' => 'Deposit Contract',
        'fields'         => [
            'id'                    => 'ID',
            'id_helper'             => '',
            'shareholder'           => 'Shareholder',
            'shareholder_helper'    => 'Related client',
            'date_calculate'        => 'Date Calculate',
            'date_calculate_helper' => 'Calculated date',
            'agreement'             => 'Agreement',
            'agreement_helper'      => 'Number of agreement',
            'date_start'            => 'Date Start',
            'date_start_helper'     => 'Start Date',
            'date_end'              => 'Date End',
            'date_end_helper'       => 'Contract End Date',
            'percent'               => 'Percent',
            'percent_helper'        => 'Number of percent for agreement',
            'is_open'               => 'Is Open',
            'is_open_helper'        => 'Is agreement open',
            'created_at'            => 'Created at',
            'created_at_helper'     => '',
            'updated_at'            => 'Updated at',
            'updated_at_helper'     => '',
            'deleted_at'            => 'Deleted at',
            'deleted_at_helper'     => '',
        ],
    ],
    'depositSchedule'    => [
        'title'          => 'Deposit Schedule',
        'title_singular' => 'Deposit Schedule',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'deposit'                  => 'Deposit',
            'deposit_helper'           => 'Related deposit agreement',
            'shareholder'              => 'Shareholder',
            'shareholder_helper'       => 'Related client',
            'date_plan'                => 'Date Plan',
            'date_plan_helper'         => 'Planned date',
            'date_fact'                => 'Date Fact',
            'date_fact_helper'         => 'Fact Date',
            'period'                   => 'Period',
            'period_helper'            => 'Period',
            'days'                     => 'Days',
            'days_helper'              => 'Days',
            'main_amt_debt'            => 'Main Amt Debt',
            'main_amt_debt_helper'     => '',
            'main_amt_fact'            => 'Main Amt Fact',
            'main_amt_fact_helper'     => '',
            'ndfl_amt'                 => 'Ndfl Amt',
            'ndfl_amt_helper'          => '',
            'percent_available'        => 'Percent Available',
            'percent_available_helper' => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
        ],
    ],
    'deposit'            => [
        'title'          => 'Deposits',
        'title_singular' => 'Deposit',
    ],
    'loan'               => [
        'title'          => 'Loans',
        'title_singular' => 'Loan',
    ],
    'loanContract'       => [
        'title'          => 'Loan Contract',
        'title_singular' => 'Loan Contract',
        'fields'         => [
            'id'                    => 'ID',
            'id_helper'             => '',
            'shareholder'           => 'Shareholder',
            'shareholder_helper'    => 'Related client',
            'date_calculate'        => 'Date Calculate',
            'date_calculate_helper' => 'Calculated date',
            'agreement'             => 'Agreement',
            'agreement_helper'      => 'Agreement number',
            'date_start'            => 'Date Start',
            'date_start_helper'     => 'Start date of agreement',
            'date_end'              => 'Date End',
            'date_end_helper'       => 'End date of agreement',
            'amount'                => 'Amount',
            'amount_helper'         => 'Amount of agreement',
            'percent'               => 'Percent',
            'percent_helper'        => 'Percent value',
            'mem_fee'               => 'Mem Fee',
            'mem_fee_helper'        => 'Mem Fee',
            'actual_debt'           => 'Actual Debt',
            'actual_debt_helper'    => 'Actual Debt',
            'full_debt'             => 'Full Debt',
            'full_debt_helper'      => 'Full Debt',
            'is_open'               => 'Is Open',
            'is_open_helper'        => 'Is agreement open',
            'created_at'            => 'Created at',
            'created_at_helper'     => '',
            'updated_at'            => 'Updated at',
            'updated_at_helper'     => '',
            'deleted_at'            => 'Deleted at',
            'deleted_at_helper'     => '',
        ],
    ],
    'loanMainSchedule'   => [
        'title'          => 'Loan Main Schedule',
        'title_singular' => 'Loan Main Schedule',
        'fields'         => [
            'id'                        => 'ID',
            'id_helper'                 => '',
            'shareholder'               => 'Shareholder',
            'shareholder_helper'        => 'Related Client',
            'loan'                      => 'Loan',
            'loan_helper'               => '',
            'date_plan'                 => 'Date Plan',
            'date_plan_helper'          => 'Date Plan',
            'date_fact'                 => 'Date Fact',
            'date_fact_helper'          => 'Date Fact',
            'period'                    => 'Period',
            'period_helper'             => 'Period',
            'days'                      => 'Days',
            'days_helper'               => 'Days',
            'main_amt_plan'             => 'Main Amt Plan',
            'main_amt_plan_helper'      => 'Main AMT Plan',
            'main_amt_fact'             => 'Main Amt Fact',
            'main_amt_fact_helper'      => '',
            'main_amt_debt_plan'        => 'Main Amt Debt Plan',
            'main_amt_debt_plan_helper' => '',
            'main_amt_debt_fact'        => 'Main Amt Debt Fact',
            'main_amt_debt_fact_helper' => '',
            'percent_amt_plan'          => 'Percent Amt Plan',
            'percent_amt_plan_helper'   => '',
            'percent_amt_fact'          => 'Percent Amt Fact',
            'percent_amt_fact_helper'   => '',
            'fee_plan'                  => 'Fee Plan',
            'fee_plan_helper'           => '',
            'fee_fact'                  => 'Fee Fact',
            'fee_fact_helper'           => '',
            'created_at'                => 'Created at',
            'created_at_helper'         => '',
            'updated_at'                => 'Updated at',
            'updated_at_helper'         => '',
            'deleted_at'                => 'Deleted at',
            'deleted_at_helper'         => '',
        ],
    ],
    'loanMemfeeSchedule' => [
        'title'          => 'Loan Memfee Schedule',
        'title_singular' => 'Loan Memfee Schedule',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => '',
            'shareholder'         => 'Shareholder',
            'shareholder_helper'  => 'Related Client',
            'loan'                => 'Loan',
            'loan_helper'         => 'Load ID',
            'date_plan'           => 'Date Plan',
            'date_plan_helper'    => 'Date Plan',
            'mem_fee_plan'        => 'Mem Fee Plan',
            'mem_fee_plan_helper' => '',
            'mem_fee_fact'        => 'Mem Fee Fact',
            'mem_fee_fact_helper' => '',
            'created_at'          => 'Created at',
            'created_at_helper'   => '',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => '',
            'deleted_at'          => 'Deleted at',
            'deleted_at_helper'   => '',
        ],
    ],
    'post'               => [
        'title'          => 'Posts',
        'title_singular' => 'Post',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Title',
            'title_helper'      => '',
            'content'           => 'Content',
            'content_helper'    => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
            'active'            => 'Active',
            'active_helper'     => '',
        ],
    ],
];
