<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Laravel\Fortify\Contracts\ResetsUserPasswords;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  array<string, string>  $input
     */
    //public function reset(User $user, array $input): void
    //{
     //   Validator::make($input, [
     //       'password' => $this->passwordRules(),
     //   ])->validate();

     //   $user->forceFill([
     //       'password' => Hash::make($input['password']),
     //   ])->save();
    //}

  //  public function reset(User $user, array $input): void
   // {
   //     Validator::make($input, [
   //         'password' => $this->passwordRules(),
   //     ])->validate();

        // Tu lógica de restablecimiento de contraseña aquí
   //     $user->forceFill([
   //         'password' => Hash::make($input['password']),
   //         'remember_token' => Str::random(60),
   //     ])->save();

   //     event(new PasswordReset($user));
   // }

// REVISAR SERVICE PROVIDER

public function reset(User $user, array $args): void
{
    Log::info('Argumentos pasados a reset():', $args);

    if (count($args) === 2 && $args[0] instanceof \App\Models\User && is_array($args[1])) {
        $user = $args[0];
        $input = $args[1];

        Log::info('Usuario:', ['id' => $user->id, 'email' => $user->email]);
        Log::info('Entrada:', $input);

        $user->forceFill([
            'password' => Hash::make($input['password']),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));
    } else {
        Log::error('Número o tipo incorrecto de argumentos pasados a reset():', $args);
        // Opcionalmente, lanza una excepción aquí para verla en el navegador si APP_DEBUG es true
        // throw new \Exception('Argumentos incorrectos pasados a reset()');
    }
}



}
