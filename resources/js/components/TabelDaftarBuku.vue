<template>
    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Stok Buku</th>
                    <th>Tersedia</th>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(book, index) in books" :key="book.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ book.stock }}</td>
                    <td>{{ book.available }}</td>
                    <td>{{ book.title }}</td>
                    <td>{{ book.author }}</td>
                    <td>{{ book.publisher }}</td>
                    <td>{{ book.year }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" @click="$emit('edit-book', book)">Edit</button>
                        <button class="btn btn-danger btn-sm" @click="$emit('delete-book', book.id)">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        books: Array,
    },
};
</script>
