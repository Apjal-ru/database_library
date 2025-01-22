<template>
    <header class="flex justify-end my-4 mx-4">
        <form method="POST" action="/logout">
            <input type="hidden" name="_token" :value="csrf">
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </header>
    <h1 class="text-4xl font-semibold text-center my-4">Peminjaman Buku</h1>
    <div class="flex flex-col justify-center">
        <div class="container p-4 bg-white py-4 rounded-xl shadow-md">
                <FormPeminjaman @form-submitted="addPeminjaman" />
        </div>
        <div class="container p-4 bg-white py-4 rounded-xl shadow-md my-4">
                <TabelPinjaman :peminjamanList="peminjamanList" />
        </div>
    </div>
</template>

<script>
import FormPeminjaman from './FormPeminjaman.vue';
import TabelPinjaman from './TabelPinjaman.vue';

export default {
    components: {
        FormPeminjaman,
        TabelPinjaman
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').content,
            peminjamanList: []

        };
    },
    methods: {
        addPeminjaman(data) {
            this.peminjamanList.push(data)
        },
        logout() {
            window.location.href = '/logout';
        },
    },
};
</script>
