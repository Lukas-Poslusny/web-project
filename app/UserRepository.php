<?php


namespace App;


use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\IIdentity;

class UserRepository implements IAuthenticator

{
    function saveUser(string $name, string $password)
    {
        $data = $this->readData();
        $data[] = ['name' => $name, 'password' => $password];

        file_put_contents(__DIR__.'/RegisteredUsers.json', json_encode($data));
    }

    function loginUser(string $name, string $password): bool
    {
        $data = $this->readData();
        foreach ($data as $user) {
            if (($user->name === $name) && ($user->password === $password)) {
                return true;
            }
        }
        return false;
    }

    function readData(): array
    {
        $json = file_get_contents(__DIR__.'/RegisteredUsers.json');
        return json_decode($json);
    }

    /**
     * Performs an authentication against e.g. database.
     * and returns IIdentity on success or throws AuthenticationException
     * @throws AuthenticationException
     */
    function authenticate(array $credentials): IIdentity
    {
        [$name, $password] = $credentials ;

        $data = $this->readData();
        foreach ($data as $user) {
            if (($user->name === $name) && ($user->password === $password)) {
                return new Identity($name, null, ['username' => $name]);
            }
        }
        throw new AuthenticationException;
    }
}
