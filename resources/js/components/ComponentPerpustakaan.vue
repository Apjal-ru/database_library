<template>
    <header class="flex justify-end my-4 mx-4">
        <form method="POST" action="/logout">
            <input type="hidden" name="_token" :value="csrf">
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </header>
    <h1 class="text-4xl font-semibold text-center my-4">Database Perpustakaan</h1>
    <div class="flex flex-col justify-center">
        <div class="container bg-white py-4 rounded-xl shadow-md">
            <!-- Tab Navigation -->
            <ul class="nav nav-pills justify-content-center mb-4">
                <li class="nav-item">
                    <button class="nav-link" :class="{ active: activeTab === 'books' }" @click="activeTab = 'books'">
                        Daftar Buku
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" :class="{ active: activeTab === 'loans' }" @click="activeTab = 'loans'">
                        Peminjaman
                    </button>
                </li>
            </ul>
            <!-- Tab Content -->
            <div v-if="activeTab === 'books'">
                <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addBookModal">
                    Tambah Buku
                </button>
                <AddBookModal :bookForm="bookForm" @save-book="addOrUpdateBook" />
                <TabelDaftarBuku :books="books" @edit-book="editBook" @delete-book="deleteBook" />
            </div>

            <div v-if="activeTab === 'loans'">
                <TabelPeminjaman :loans="loans" @delete-loan="deleteLoan" />
            </div>
        </div>
    </div>
</template>

<script>
import AddBookModal from './AddBookModal.vue';
import TabelDaftarBuku from './TabelDaftarBuku.vue';
import TabelPeminjaman from './TabelPeminjaman.vue';

export default {
    components: {
        TabelDaftarBuku,
        TabelPeminjaman,
        AddBookModal,
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').content,
            activeTab: 'books',
            books: [],
            loans: [],
            bookForm: {
                id: null,
                amount: '',
                title: '',
                author: '',
                publisher: '',
                year: '',
            },
        };
    },
    async created() {
        await this.fetchBooks();
    },
    methods: {
        async fetchBooks() {
            try {
                const response = await fetch('/api/books', {
                    headers: {
                        'X-CSRF-TOKEN': this.csrf
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch books');
                }

                const data = await response.json();
                this.books = data.books;
            } catch (error) {
                console.error('Error fetching books:', error);

            }
        },
        async addOrUpdateBook() {
            try {
                if (this.bookForm.id) {
                    // Update logic akan ditambahkan nanti
                } else {
                    const response = await fetch('/books', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrf
                        },
                        body: JSON.stringify({
                            stock: parseInt(this.bookForm.amount),
                            title: this.bookForm.title,
                            author: this.bookForm.author,
                            publisher: this.bookForm.publisher,
                            year: parseInt(this.bookForm.year)
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        // Tambahkan buku baru ke array books
                        this.books.push(data.book);
                        // Reset form
                        this.bookForm = {
                            id: null,
                            amount: '',
                            title: '',
                            author: '',
                            publisher: '',
                            year: ''
                        };
                        // Tutup modal
                        const modal = document.getElementById('addBookModal');
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        modalInstance.hide();
                        // Tampilkan pesan sukses
                        alert('Buku berhasil ditambahkan');
                    } else {
                        throw new Error(data.message);
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal menambahkan buku: ' + error.message);
            }
        },
        closeModal() {
        const modal = document.getElementById('addBookModal');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
        },
        editBook(book) {
            this.bookForm = { ...book };
        },
        deleteBook(id) {
            // Delete book logic
        },
        deleteLoan(id) {
            // Delete loan logic
        },
        logout() {
            window.location.href = '/logout';
        },
    },
};
</script>
