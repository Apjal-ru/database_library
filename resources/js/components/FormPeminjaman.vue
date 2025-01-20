<template>
    <div>
        <h2 class="text-2xl font-bold mb-4">Form Peminjaman</h2>
        <form @submit.prevent="submitForm">
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Peminjam</label>
                <input
                    type="text"
                    id="nama"
                    v-model="form.nama"
                    class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    required
                />
            </div>

            <div class="mb-4">
                <label for="buku" class="block text-sm font-medium text-gray-700">Judul Buku</label>
                <input
                    type="text"
                    id="buku"
                    v-model="form.buku"
                    class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    required
                />
            </div>
            <button
                type="submit"
                class="py-2 px-4 bg-blue-500 text-white rounded-md hover:bg-blue-600"
            >
                Submit
            </button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                nama: '',
                buku: '',
                tanggal: ''
            }
        };
    },
    methods: {
        submitForm() {
            this.$emit('form-submitted', { ...this.form });
            this.form.nama = '';
            this.form.buku = '';
            this.form.tanggal = '';
        }
    }
};
</script>

<style scoped>
/* Add any necessary styles here */
</style>
