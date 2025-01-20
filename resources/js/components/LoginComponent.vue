<template>
    <div class="flex justify-center items-center min-h-screen">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-3xl font-bold text-center mb-4">Perpustakaan Online</h1>
            <div class="text-center mb-4">
                <h4 class="text-xl font-semibold">Login</h4>
            </div>
            <form @submit.prevent="handleLogin">
                <!-- Username Field -->
                <div class="mb-4">
                    <label for="loginUsername" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="loginUsername" v-model="formData.username"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        required />
                </div>

                <!-- Password Field -->
                <div class="mb-4">
                    <label for="loginPassword" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="loginPassword" v-model="formData.password"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        required />
                </div>

                <!-- Submit Button -->
                <div class="mb-4">
                    <button type="submit"
                        class="w-full py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 disabled:bg-blue-300"
                        :disabled="loading">
                        {{ loading ? 'Loading...' : 'Login' }}
                    </button>
                </div>

                <!-- Error Message -->
                <div v-if="error" class="text-red-500 text-sm text-center mt-2">
                    {{ error }}
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            formData: {
                username: '',
                password: ''
            },
            loading: false,
            error: null
        }
    },
    methods: {
        async handleLogin() {
            this.loading = true;
            this.error = null;

            try {
                console.log('Sending login request with:', this.formData); // Debug log

                const response = await fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(this.formData)
                });

                const data = await response.json();
                console.log('Response:', data); // Debug log

                if (response.ok) {
                    window.location.href = data.redirect;
                } else {
                    this.error = `Error: ${data.message}`;
                    console.error('Login failed:', data); // Debug log
                }
            } catch (error) {
                console.error('Login error:', error);
                this.error = `Error: ${error.message}`;
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
