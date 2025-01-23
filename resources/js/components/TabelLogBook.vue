<template>
    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(log, index) in logs" :key="log.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ log.nama_peminjam }}</td>
                    <td>{{ log.judul_buku }}</td>
                    <td>{{ formatDate(log.tanggal) }}</td>
                    <td>
                        <span class="badge" :class="{
                            'bg-success': log.status === 'dikembalikan',
                            'bg-warning': log.status === 'dipinjam',
                        }">
                            {{ log.status }}
                        </span>
                    </td>
                </tr>
                <tr v-if="logs.length === 0">
                    <td colspan="5" class="text-center">Tidak ada data peminjaman</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props: {
        logs: {
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
};
</script>
