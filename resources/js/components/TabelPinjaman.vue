<template>
    <div>
        <h2 class="text-2xl font-bold mb-4">List Pinjaman</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Penerbit Buku</th>
                    <th>Jumlah</th>
                    <th>Terbit</th>
                    <th>Tanggal Peminjaman</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in peminjamanList" :key="item.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ item.nama_peminjam }}</td>
                    <td>{{ item.judul_buku }}</td>
                    <td>{{ item.penerbit_buku }}</td>
                    <td>{{ item.jumlah }}</td>
                    <td>{{ item.terbit }}</td>
                    <td>{{ item.tanggal_peminjaman }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        peminjamanList: Array,
    }
};
</script>
