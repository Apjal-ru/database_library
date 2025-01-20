<template>
    <header class="flex justify-end my-4 mx-4">
        <form method="POST" action="/logout">
            <input type="hidden" name="_token" :value="csrf">
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </header>
    <h1 class="text-4xl font-semibold text-center my-4">Peminjaman Buku</h1>
    <div class="flex flex-col justify-center">
        <div class="container bg-white py-4 rounded-xl">

        </div>
    </div>
</template>
