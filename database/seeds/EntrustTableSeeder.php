<?php

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class EntrustTableSeeder extends Seeder {

	public function run()
	{

		DB::table('role_user')->delete();
		DB::table('permission_role')->delete();
		DB::table('roles')->delete();
		DB::table('permissions')->delete();

		$admin = new Role(); // 1
		$admin->name = 'admin';
		$admin->display_name = "Administrator";
		$admin->save();

		$editor = new Role(); // 2
		$editor->name = 'editor';
		$editor->display_name = "Editor";
		$editor->save();

		$userRole = new Role(); // 3
		$userRole->name = 'user';
		$userRole->display_name = "User";
		$userRole->save();

		$user = User::where('email', '=', 'jennieruff@gmail.com')->first();
		$user->attachRole($admin);
		//$user->roles()->attach($admin->id); Eloquent basic

		$manageRoles = new Permission();
		$manageRoles->name = 'manage_roles';
		$manageRoles->display_name = "Manage roles";
		$manageRoles->description = "";
		$manageRoles->route = "roles";
		$manageRoles->save();

		$createRoles = new Permission();
		$createRoles->name = 'create_roles';
		$createRoles->display_name = "Create roles";
		$createRoles->description = "";
		$createRoles->route = "roles/create";
		$createRoles->save();

		$updateRoles = new Permission();
		$updateRoles->name = 'update_roles';
		$updateRoles->display_name = "Update roles";
		$updateRoles->description = "";
		$updateRoles->route = "roles/{roles}/edit";
		$updateRoles->save();

		$destroyRoles = new Permission();
		$destroyRoles->name = 'delete_roles';
		$destroyRoles->display_name = "Delete roles";
		$destroyRoles->description = "";
		$destroyRoles->route = "roles/{roles}";
		$destroyRoles->save();


		$manageUsers = new Permission();
		$manageUsers->name = 'manage_users';
		$manageUsers->display_name = "Manager users";
		$manageUsers->description = "";
		$manageUsers->route = "users";
		$manageUsers->save();

		$createUsers = new Permission();
		$createUsers->name = 'create_users';
		$createUsers->display_name = "Create users";
		$createUsers->description = "";
		$createUsers->route = "users/create";
		$createUsers->save();

		$updateUsers = new Permission();
		$updateUsers->name = 'update_users';
		$updateUsers->display_name = "Update users";
		$updateUsers->description = "";
		$updateUsers->route = "users/{users}/edit";
		$updateUsers->save();

		$destroyUsers = new Permission();
		$destroyUsers->name = 'delete_users';
		$destroyUsers->display_name = "Delete users";
		$destroyUsers->description = "";
		$destroyUsers->route = "users/{users}";
		$destroyUsers->save();


		$managePerms = new Permission();
		$managePerms->name = 'manage_permissions';
		$managePerms->display_name = "Manage permissions";
		$managePerms->description = "";
		$managePerms->route = "permissions";
		$managePerms->save();

		$createPerms = new Permission();
		$createPerms->name = 'create_permissions';
		$createPerms->display_name = "Create permissions";
		$createPerms->description = "";
		$createPerms->route = "permissions/create";
		$createPerms->save();

		$updatePerms = new Permission();
		$updatePerms->name = 'update_permissions';
		$updatePerms->display_name = "Update permissions";
		$updatePerms->description = "";
		$updatePerms->route = "permissions/{permissions}/edit";
		$updatePerms->save();

		$destroyPerms = new Permission();
		$destroyPerms->name = 'delete_permissions';
		$destroyPerms->display_name = "Delete permissions";
		$destroyPerms->description = "";
		$destroyPerms->route = "permissions/{permissions}";
		$destroyPerms->save();

		$admin->attachPermissions([$manageRoles, $createRoles, $updateRoles, $destroyRoles, $manageUsers, $createUsers, $updateUsers, $destroyUsers, $managePerms, $createPerms, $updatePerms, $destroyPerms]);
		//$admin->perms()->sync([$manageRoles->id, $manageUsers->id, $managePerms->id]); Eloquent basic

		$editor->attachPermissions([$managePerms, $createPerms, $updatePerms, $destroyPerms]);
	}

}