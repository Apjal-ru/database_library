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
                <tr v-for="(loan, index) in peminjamanList" :key="loan.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ loan.nama_peminjam }}</td>
                    <td>{{ loan.judul_buku }}</td>
                    <td>{{ loan.penerbit_buku }}</td>
                    <td>{{ loan.jumlah }}</td>
                    <td>{{ loan.terbit }}</td>
                    <td>{{ formatDate(loan.tanggal_peminjaman) }}</td>
                    <td>
                        <button
                            class="btn btn-danger btn-sm"
                            @click="$emit('delete-loan', loan.id)"
                        >
                            Hapus
                        </button>
                    </td>
                </tr>
                <tr v-if="peminjamanList.length === 0">
                    <td colspan="8" class="text-center">Tidak ada data peminjaman</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: 'TabelPeminjaman',
    props: {
        peminjamanList: {
            type: Array,
            required: true,
            default: () => []
        }
    },
    methods: {
        formatDate(date) {
            if (!date) return '';
            return new Date(date).toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
    }
}
</script>
