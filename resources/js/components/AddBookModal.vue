/* File: AddBookModal.vue */
<template>
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-bold" id="addBookModalLabel">Tambah Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="$emit('save-book', bookForm)">
                        <div class="mb-3">
                            <label for="bookAmount" class="form-label">Stok Buku</label>
                            <input type="number" v-model="bookForm.amount" id="bookAmount" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="bookTitle" class="form-label">Judul Buku</label>
                            <input type="text" v-model="bookForm.title" id="bookTitle" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="bookAuthor" class="form-label">Pengarang</label>
                            <input type="text" v-model="bookForm.author" id="bookAuthor" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="bookPublisher" class="form-label">Penerbit</label>
                            <input type="text" v-model="bookForm.publisher" id="bookPublisher" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="bookYear" class="form-label">Tahun Terbit</label>
                            <input type="number" v-model="bookForm.year" id="bookYear" class="form-control" required />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
        bookForm: Object,
    },
};
</script>
