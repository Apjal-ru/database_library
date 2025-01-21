<template>
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookModalLabel">
                        {{ bookForm.id ? 'Edit Buku' : 'Tambah Buku' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="resetForm"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="validateAndSubmit">
                        <div class="mb-3">
                            <label for="amount" class="form-label">Jumlah Buku</label>
                            <input type="text"
                                class="form-control"
                                :class="{ 'is-invalid': errors.amount }"
                                id="amount"
                                v-model="bookForm.amount"
                                @input="validateNumber($event, 'amount')"
                            >
                            <div class="invalid-feedback">{{ errors.amount }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Buku</label>
                            <input type="text"
                                class="form-control"
                                :class="{ 'is-invalid': errors.title }"
                                id="title"
                                v-model="bookForm.title"
                                @input="validateAlphabet($event, 'title')"
                            >
                            <div class="invalid-feedback">{{ errors.title }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Pengarang</label>
                            <input type="text"
                                class="form-control"
                                :class="{ 'is-invalid': errors.author }"
                                id="author"
                                v-model="bookForm.author"
                                @input="validateAlphabet($event, 'author')"
                            >
                            <div class="invalid-feedback">{{ errors.author }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="publisher" class="form-label">Penerbit</label>
                            <input type="text"
                                class="form-control"
                                :class="{ 'is-invalid': errors.publisher }"
                                id="publisher"
                                v-model="bookForm.publisher"
                                @input="validateAlphabet($event, 'publisher')"
                            >
                            <div class="invalid-feedback">{{ errors.publisher }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Tahun Terbit</label>
                            <input type="text"
                                class="form-control"
                                :class="{ 'is-invalid': errors.year }"
                                id="year"
                                v-model="bookForm.year"
                                @input="validateNumber($event, 'year')"
                            >
                            <div class="invalid-feedback">{{ errors.year }}</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="resetForm">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        bookForm: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            errors: {
                amount: '',
                title: '',
                author: '',
                publisher: '',
                year: ''
            },
            localBookForm: { ...this.bookForm }
        }
    },
    methods: {
        validateNumber(event, field) {
            // Hanya mengizinkan input angka
            const value = event.target.value;
            if (!/^\d*$/.test(value)) {
                this.errors[field] = 'Hanya boleh diisi angka';
                this.bookForm[field] = value.replace(/\D/g, '');
                return;
            }

            if (field === 'year') {
                const currentYear = new Date().getFullYear();
                if (parseInt(value) > currentYear) {
                    this.errors.year = `Tahun tidak boleh melebihi ${currentYear}`;
                    return;
                }
            }

            this.errors[field] = '';
        },
        validateAlphabet(event, field) {
            // Hanya mengizinkan input huruf
            const value = event.target.value;
            if (!/^[a-zA-Z\s]*$/.test(value)) {
                this.errors[field] = 'Hanya boleh diisi huruf';
                this.bookForm[field] = value.replace(/[^a-zA-Z\s]/g, '');
                return;
            }

            this.errors[field] = '';
        },
        validateAndSubmit() {
            // Reset error messages
            this.errors = {
                amount: '',
                title: '',
                author: '',
                publisher: '',
                year: ''
            };

            // Validasi field kosong
            if (!this.bookForm.amount) this.errors.amount = 'Jumlah buku harus diisi';
            if (!this.bookForm.title) this.errors.title = 'Judul buku harus diisi';
            if (!this.bookForm.author) this.errors.author = 'Pengarang harus diisi';
            if (!this.bookForm.publisher) this.errors.publisher = 'Penerbit harus diisi';
            if (!this.bookForm.year) this.errors.year = 'Tahun terbit harus diisi';

            // Validasi tahun
            const currentYear = new Date().getFullYear();
            if (parseInt(this.bookForm.year) > currentYear) {
                this.errors.year = `Tahun tidak boleh melebihi ${currentYear}`;
            }

            // Cek jika ada error
            if (Object.values(this.errors).some(error => error !== '')) {
                return;
            }

            // Jika validasi berhasil, emit event save-book
            this.$emit('save-book');
        },
        resetForm() {
            // Reset form ke nilai awal
            this.bookForm.id = null;
            this.bookForm.amount = '';
            this.bookForm.title = '';
            this.bookForm.author = '';
            this.bookForm.publisher = '';
            this.bookForm.year = '';

            // Reset error messages
            this.errors = {
                amount: '',
                title: '',
                author: '',
                publisher: '',
                year: ''
            };
        }
    }
}
</script>
