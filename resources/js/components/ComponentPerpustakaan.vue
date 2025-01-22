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
                <TabelPeminjaman :peminjamanList="loans" @delete-loan="deleteLoan" />
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
        AddBookModal,
        TabelDaftarBuku,
        TabelPeminjaman,

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
        await this.fetchLoans();
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
        async fetchLoans() {
            try {
                const response = await fetch('/api/peminjaman', {
                    headers: {
                        'X-CSRF-TOKEN': this.csrf
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch loans');
                }

                const data = await response.json();
                this.loans = data.loans;
            } catch (error) {
                console.error('Error fetching loans:', error);

            }
        },
        async addOrUpdateBook() {
            try {
                const formData = {
                    stock: parseInt(this.bookForm.amount),
                    title: this.bookForm.title,
                    author: this.bookForm.author,
                    publisher: this.bookForm.publisher,
                    year: parseInt(this.bookForm.year)
                };

                let response;
                if (this.bookForm.id) {
                    response = await fetch(`/books/${this.bookForm.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrf
                        },
                        body: JSON.stringify(formData)
                    });
                } else {
                    response = await fetch('/books', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrf
                        },
                        body: JSON.stringify(formData)
                    });
                }

                const data = await response.json();

                if (response.ok) {
                    if (this.bookForm.id) {
                        const index = this.books.findIndex(book => book.id === this.bookForm.id);
                        if (index !== -1) {
                            this.books[index] = data.book;
                        }
                    } else {
                        this.books.push(data.book);
                    }
                    this.bookForm = {
                        id: null,
                        amount: '',
                        title: '',
                        author: '',
                        publisher: '',
                        year: ''
                    };

                    const modal = document.getElementById('addBookModal');
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    modalInstance.hide();
                    alert(data.message);
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal menyimpan buku: ' + error.message);
            }
        },
        editBook(book) {
            this.bookForm = {
                id: book.id,
                amount: book.stock.toString(),
                title: book.title,
                author: book.author,
                publisher: book.publisher,
                year: book.year.toString()
            };
            const modal = new bootstrap.Modal(document.getElementById('addBookModal'));
            modal.show();
        },
        closeModal() {
            const modal = document.getElementById('addBookModal');
            const modalInstance = bootstrap.Modal.getInstance(modal);
            modalInstance.hide();
        },
        async deleteBook(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus buku ini?')) {
                return;
            }

            try {
                const response = await fetch(`/books/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': this.csrf
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    // Hapus buku dari array
                    this.books = this.books.filter(book => book.id !== id);
                    alert(data.message);
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal menghapus buku: ' + error.message);
            }
        },
        async deleteLoan(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')) {
                return;
            }

            try {
                fetch(`/api/peminjaman/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': this.csrf,
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.loans = this.loans.filter(loan => loan.id !== id);
                            alert('Peminjaman berhasil dihapus');
                        } else {
                            throw new Error(data.message);
                        }
                    });
            } catch (error) {
                console.error('Error deleting loan:', error);
                alert('Gagal menghapus peminjaman: ' + error.message);
            }
        },
        logout() {
            window.location.href = '/logout';
        },
    },
};
</script>
