import './bootstrap';
import { createApp } from 'vue';
import LoginComponent from './components/LoginComponent.vue';
import ComponentPerpustakaan from './components/ComponentPerpustakaan.vue';
import ComponentPeminjaman from './components/ComponentPeminjaman.vue';
import TabelDaftarBuku from './components/TabelDaftarBuku.vue';
import TabelPeminjaman from './components/TabelPeminjaman.vue';
import AddBookModal from './components/AddBookModal.vue';
import FormPeminjaman from './components/FormPeminjaman.vue';
import TabelPinjaman from './components/TabelPinjaman.vue';

const app = createApp({});
app.component('login-component', LoginComponent);
app.component('component-perpustakaan', ComponentPerpustakaan);
app.component('tabel-daftar-buku', TabelDaftarBuku);
app.component('tabel-peminjaman', TabelPeminjaman);
app.component('add-book-modal', AddBookModal);
app.component('component-peminjaman', ComponentPeminjaman);
app.component('form-peminjaman', FormPeminjaman);
app.component('tabel-pinjaman', TabelPinjaman);

app.mount('#app');
