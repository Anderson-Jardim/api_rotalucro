<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Rules\Contact;
use App\Models\valorKM;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\PasswordReset;

class AuthController extends Controller
{
    //Register user
    public function register(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            /* 'contact' => ['required', 'string', 'max:255', new Contact], */
            'contact' => ['required', 'string', 'email', 'max:50'],
            'password' => 'required|min:6|confirmed'
        ]);

        //create user
        $user = User::create([
            'name' => $attrs['name'],
            'username' => $attrs['username'],
            'contact' => $attrs['contact'],
            'password' => bcrypt($attrs['password'])
        ]);

        // Criação do registro na tabela 'valor_km' com valores padrão para "ruim" e "bom"
        valorKM::create([
            'user_id' => $user->id,   // Atribui o ID do usuário
            'ruim' => 0.5,            // Valor padrão para "ruim"
            'bom' => 0.95,            // Valor padrão para "bom"
        ]);
        
        //return user & token in response
        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ], 200);
        
      
        
    }

    // login user
    public function login(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'contact' => ['required', new Contact],
            'password' => 'required|min:6'
        ]);

        // attempt login
        if(!Auth::attempt($attrs))
        {
            return response([
                'message' => 'Invalid credentials.'
            ], 403);
        }

        //return user & token in response
        return response([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('secret')->plainTextToken
        ], 200);
    }

    // logout user
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Logout success.'
        ], 200);
    }

    // get user details
    public function user()
    {
        return response([
            'user' => auth()->user()
        ], 200);
    }

    // update user
    public function update(Request $request)
    {
        $attrs = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'contact' => ['required', 'string', 'max:255', new Contact],
            'password' => 'required|min:6|confirmed'
        ]);

        //$image = $this->saveImage($request->image, 'profiles');

        auth()->user()->update([
            'name' => $attrs['name'],
            'username' => $attrs['username'],
            'contact' => $attrs['contact'],
            'password' => bcrypt($attrs['password'])
        ]);

        return response([
            'message' => 'Dados atualizados',
            'user' => auth()->user()
        ], 200);
    }

    public function esqueciminhaSenha(Request $request)
{
    $request->validate([
        'contact' => 'required',
    ]);

    $user = User::where('contact', $request->contact)->first();
    if (!$user || !$user->contact) {
        return response()->json(['message' => 'Usuário não encontrado ou sem e-mail cadastrado.'], 404);
    }

    // Gera um token aleatório
    $token = Str::random(6); // ou Str::uuid();

    // Salva no banco (hash para segurança)
    PasswordReset::updateOrCreate(
        ['contact' => $user->contact],
        ['token' => Hash::make($token), 'created_at' => now()]
    );

    // Envia o token por e-mail
    Mail::send('emails.reset', ['token' => $token], function ($message) use ($user) {
        $message->to($user->contact);
        $message->subject('Código para Redefinir Senha');
    });

    return response()->json(['message' => 'Token enviado por e-mail com sucesso.']);
}


    // Resetar senha
public function redefinirSenha(Request $request)
{
    $request->validate([
        'contact' => 'required',
        'password' => 'required|min:6|confirmed',
        'token' => 'required'
    ]);

    // Busca o usuário pelo contato
    $user = User::where('contact', $request->contact)->first();
    if (!$user) {
        return response(['message' => 'Contato não encontrado'], 404);
    }

    // Verifica se o token é válido
    $reset = PasswordReset::where('contact', $user->contact)->first();
    if (!$reset || !Hash::check($request->token, $reset->token)) {
        return response(['message' => 'Token inválido'], 400);
    }

    // Atualiza a senha do usuário
    $user->update(['password' => bcrypt($request->password)]);

    // Remove o token de redefinição usado
    $reset->delete();

    return response(['message' => 'Senha redefinida com sucesso'], 200);
}


}
