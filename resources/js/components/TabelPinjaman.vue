<template>
    <div>
        <h2 class="text-2xl font-bold mb-4">Buku Yang Kamu Pinjam</h2>
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
                <tr v-for="(loan, index) in peminjamanList" :key="loan.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ loan.nama_peminjam }}</td>
                    <td>{{ loan.judul_buku }}</td>
                    <td>{{ loan.penerbit_buku }}</td>
                    <td>{{ loan.jumlah }}</td>
                    <td>{{ loan.terbit }}</td>
                    <td>{{ loan.tanggal_peminjaman }}</td>
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
