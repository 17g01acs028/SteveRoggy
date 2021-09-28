<?php


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'allocation-list',
           'allocation-create',
           'allocation-edit',
           'allocation-delete',
           'allocation-approve',
           'client-list',
           'client-create',
           'client-edit',
           'client-delete',
           'client-credit',
           'client-createStep1',
           'client-postCreateStep1',
           'client-postCreateStep2',
           'client-postCreateStep3',
           'client-approve',
           'client-dissapprove',
           'clientSender-show',
           'clientSender-detach',
           'contact-list',
           'contact-create',
           'contact-edit',
           'contact-delete',
           'contact-getImport',
           'contact-parseImport',
           'contact-processImport',
           'contactGroup-show',
           'contactGroup-detach',
           'group-list',
           'group-create',
           'group-edit',
           'group-delete',
           'group-createStep1',
           'group-postCreateStep1',
           'group-postCreateStep2',
           'home-list',
           'invite-list',
           'invite-delete',
           'message-list',
           'message-create',
           'message-createStep1',
           'message-postCreateStep1',
           'message-postCreateStep2',
           'network-list',
           'network-create',
           'network-edit',
           'network-delete',
           'network-createStep1',
           'network-postCreateStep1',
           'network-postCreateStep2',
           'prefix-list',
           'prefix-create',
           'prefix-edit',
           'prefix-delete',
           'route-list',
           'route-create',
           'route-edit',
           'route-delete',
           'routeMap-list',
           'routeMap-create',
           'routeMap-edit',
           'routeMap-delete',
           'schedule-list',
           'schedule-create',
           'schedule-edit',
           'schedule-delete',
           'sender-list',
           'sender-create',
           'sender-edit',
           'sender-delete',
           'template-list',
           'template-create',
           'template-edit',
           'template-delete',
           'user-list',
           'user-create',
           'user-edit',
           'user-delete',
           'user-invite_view',
           'user-process_invites',
           'user-edit_user',
           'user-update_user',
           'user-show_user',
           'user-show_client',
           'notification-list',
           'notification-create',
           'notification-edit',
           'notification-delete',
           'transaction-list',
           'mpesaCode-list',
           'mpesaCode-create',
           'mpesaCode-delete',

        ];


        foreach ($permissions as $permission) {
             Permission::updateOrCreate(['guard_name' => 'web','name' => $permission]);
        }
    }
}
