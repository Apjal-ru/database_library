<template>
    <div>
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
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(loan, index) in loans" :key="loan.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ loan.borrower }}</td>
                    <td>{{ loan.book }}</td>
                    <td>{{ loan.quantity }}</td>
                    <td>{{ loan.date }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" @click="$emit('delete-loan', loan.id)">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        loans: Array,
    },
};
</script>
