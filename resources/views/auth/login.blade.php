<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تسجيل الدخول|HRMS</title>
</head>
<body>
    <style>
    body{
        margin:  0;
        font-family: "Segoe UI ", Tahoma; 
        background: url('{{ asset("storage/images/h2.png") }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        height: 100vh;
        display: flex ; 
        align-items:center; 
        justify-content: center; 
    }
     
    .login-card {
        background: #fff;
        width: 380px; 
        padding:  35px; 
        border-radius: 10px; 
        box-shadow: 0 15px 30px rgba(0,0,0,.25);
    }
   
    
    .login-card h2   {
      text-align: center;
      margin-bottom: 25px;
       color: #1E3A8A;
        }

    .lottie-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-bottom: 25px;
    }

    .lottie-animation {
        width: 60px;
        height: 60px;
    }

    .login-title {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        color: #1E3A8A;
        font-size: 24px;
        font-weight: bold;
    }



    .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 13px;
            display: block;
            margin-bottom: 5px;
            color: #1F2937;
        }

        input {
            width: 100%;
            padding: 7px 12px;
            border-radius: 5px;
            border: 1px solid #E5E7EB;
            font-size: 13px;
            color: #1F2937;
        }

        input:focus {
            outline: none;
            border-color: #1E3A8A;
            box-shadow: 0 0 0 2px rgba(30, 58, 138, 0.1);
        }

        .remember {
            display: flex;
            align-items: center;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .remember input {
            width: auto;
            margin-left: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #1E3A8A;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #3B82F6;
        }

        .error {
            background: #ffe5e5;
            color: #c0392b;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 15px;
        }

   </style>
    
     <div class="login-card">
         <div class="login-title">
             <x-lottie 
                 class="lottie-animation"
                 style="width: 60px; height: 60px;"
                 path="{{ $lottiePath }}"
                 animType="svg"
                 loop="true"
                 autoplay="true"
             ></x-lottie>
             <h2 style="margin: 0;">HRMS login</h2>
         </div>

         @if ($errors->any())
         <div class="error">{{$errors->first()}}</div> 
         @endif 

         <form method="POST" action="{{ route('login') }}">
          @csrf
          
          <div class="form-group">
            <label>اسم المستخدم</label>
            <input type="text" name="username" value="{{ old('username') }}" required autofocus>
            @error('username')
                <span style="color: #c0392b; font-size: 12px; display: block; margin-top: 5px;">{{ $message }}</span>
            @enderror
          </div>
         
          <div class="form-group">
            <label>كلمة المرور</label>
            <input type="password" name="password" required>
            @error('password')
                <span style="color: #c0392b; font-size: 12px; display: block; margin-top: 5px;">{{ $message }}</span>
            @enderror
          </div>

          <button type="submit">تسجيل الدخول</button>
         </form>

       
         </div>
</body>
</html>