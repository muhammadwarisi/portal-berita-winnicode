<?php

namespace App\Services\User;

interface UserServiceInterface
{
public function getAllUser();
public function getUserRoles();
// public function getById($id);
public function createUser($data);
// public function updateUser($id, $data);
// public function deleteUser($id);
}
