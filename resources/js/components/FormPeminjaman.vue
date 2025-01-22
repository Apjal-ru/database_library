<template>
    <div>
        <h2 class="text-2xl font-bold mb-4">Form Peminjaman</h2>
        <form @submit.prevent="submitForm">
            <div class="mb-4">
                <label for="id" class="block text-sm font-medium text-gray-700">Judul Buku</label>
                <select
                    id="id"
                    v-model="form.id"
                    class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    required
                >
                    <option value="" disabled>Pilih Buku</option>
                    <option v-for="buku in availableBooks"
                            :key="buku.id"
                            :value="buku.id"
                            :disabled="buku.available_stock === 0">
                        {{ `${buku.title} (${buku.year}) - ${buku.publisher}` }}
                        {{ buku.available_stock === 0 ? ' (Stok Habis)' : '' }}
                    </option>
                </select>
            </div>
            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Pinjam</label>
                <input
                    type="text"
                    id="jumlah"
                    v-model="form.jumlah"
                    min="1"
                    :max="selectedBookStock"
                    @input="validateNumber($event, 'jumlah')"
                    class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    required
                />
                <span v-if="selectedBookStock" class="text-sm text-gray-500">
                    Stok tersedia: {{ selectedBookStock }}
                </span>
            </div>
            <button
                type="submit"
                class="py-2 px-4 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                :disabled="!isFormValid"
            >
                Pinjam
            </button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                id: '',
                jumlah: ''
            },
            availableBooks: [],
            errors: {}
        };
    },
    computed: {
        selectedBookStock() {
            const selectedBook = this.availableBooks.find(book => book.id === this.form.id);
            return selectedBook ? selectedBook.available_stock : 0;
        },
        isFormValid() {
            return this.form.id &&
                   this.form.jumlah &&
                   this.form.jumlah > 0 &&
                   this.form.jumlah <= this.selectedBookStock;
        }
    },
    async created() {
        await this.fetchBooks();
    },
    methods: {
        validateNumber(event, field) {
            // Hanya mengizinkan input angka
            const value = event.target.value;
            if (!/^\d*$/.test(value)) {
                this.errors[field] = 'Hanya boleh diisi angka';
                this.form[field] = value.replace(/\D/g, '');
                return;
            }
            this.errors[field] = '';
        },
        async fetchBooks() {
            try {
                const response = await fetch('/api/books');
                if (!response.ok) throw new Error('Failed to fetch books');
                const data = await response.json();
                this.availableBooks = data.books;
            } catch (error) {
                console.error('Error fetching books:', error);
                alert('Gagal mengambil data buku');
            }
        },
        async submitForm() {
            if (!this.isFormValid) return;

            const selectedBook = this.availableBooks.find(book => book.id === this.form.id);

            try {
                const response = await fetch('/api/peminjaman', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        id: this.form.id,
                        jumlah: parseInt(this.form.jumlah)
                    })
                });

                if (!response.ok) throw new Error('Failed to submit form');

                const data = await response.json();
                this.$emit('form-submitted', data.peminjaman);

                // Reset form
                this.form.id = '';
                this.form.jumlah = '';

                // Refresh book list to update available stock
                await this.fetchBooks();

                alert('Peminjaman berhasil');
            } catch (error) {
                console.error('Error submitting form:', error);
                alert('Gagal melakukan peminjaman');
            }
        }
    }
};
</script>
