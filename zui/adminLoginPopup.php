<div class="w-[100vw] h-[100vh] flex justify-center items-center bg-[#00000080] fixed top-0 left-0 z-50" id="admin-login-popup">
    <div class="form-box bg-white p-8 rounded-lg shadow-lg w-96">
        <div class="tab flex justify-between mb-4">
            <button class="active px-4 py-2 border-b-2 border-blue-500" id="login-tab">Login</button>
            <button class="px-4 py-2" id="register-tab">Register</button>
        </div>
        <form action="" method="post" id="admin-login-form">
            <div class="mb-4">
                <input type="text" name="username" id="username" placeholder="Username" required class="w-full px-3 py-2 border rounded">
            </div>
            <div class="password-wrapper mb-4">
                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="Password" required class="w-full px-3 py-2 border rounded">
                    <span class="toggle-password absolute right-3 top-3 cursor-pointer text-blue-500" id="toggle-password">Show</span>
                </div>
            </div>

            <button type="submit" id="submit" class="w-full bg-blue-500 text-white py-2 rounded">Login</button>
        </form>
    </div>
</div>