📘 BLUEPRINT PROJECT
Smart Allocation & Money Flow Web App

Project ini adalah sebuah web app keuangan berbasis Laravel yang berfokus pada sistem pembagian dan pengelolaan aliran uang secara terstruktur, bukan sekadar pencatatan transaksi. Aplikasi ini ditujukan untuk individu yang memiliki penghasilan—baik tetap seperti karyawan maupun tidak tetap seperti freelancer atau pedagang—yang ingin memiliki sistem sederhana namun disiplin dalam mengatur uangnya.

Inti dari aplikasi ini adalah konsep Income as Event dan Allocation as System. Setiap pemasukan dicatat sebagai sebuah event dengan tanggal nyata, bukan sebagai “gaji bulanan tetap”. Artinya, user dapat mencatat pemasukan kapan pun mereka menerima uang, bahkan lebih dari sekali dalam satu bulan. Sistem kemudian membaca data tersebut dan memungkinkan visualisasi baik secara detail per tanggal maupun secara agregasi per bulan.

🔐 Sistem Akses & Struktur Dasar

Aplikasi menggunakan sistem login per user. Tidak ada admin pada versi awal, karena fokus aplikasi adalah personal financial system, bukan platform publik atau SaaS. Setiap user memiliki data, aturan alokasi, dan fund (dompet virtual) masing-masing.

Setelah login, user langsung masuk ke Dashboard sebagai pusat kontrol utama.

🏠 Dashboard (Home System)

Dashboard berfungsi sebagai ringkasan kondisi keuangan user saat ini. Di dalamnya terdapat:

Ringkasan total income terbaru

Total saldo seluruh fund

Card atau section fund yang dibuat user

Riwayat transaksi terbaru

Grafik income dengan dua mode tampilan (Daily & Monthly)

Tombol “+ Pemasukan Baru”

Dashboard bukan tempat untuk mengatur sistem, melainkan tempat melihat hasil sistem bekerja.

💰 Income Module (Event-Based Income)

Income dicatat sebagai event dengan tanggal aktual. User dapat mencatat pemasukan kapan saja, tanpa batasan bulanan.

Saat user menambahkan pemasukan, terdapat opsi:

Mode Real (default): pemasukan diproses dan memengaruhi saldo fund

Mode Simulation: pemasukan hanya dihitung untuk melihat hasil alokasi tanpa mengubah saldo atau histori fund

Mode Simulation berfungsi sebagai kalkulator perencanaan keuangan dan tidak mengganggu data asli.

⚙️ Allocation System (Aturan Tetap)

Allocation bukan bagian dari transaksi, melainkan rule system yang berdiri sendiri. User mengatur persentase pembagian dana di menu khusus Allocation Settings.

Contoh:

50% Kebutuhan

20% Tabungan

20% Investasi

10% Hiburan

Aturan ini berlaku otomatis setiap kali income (mode real) diproses. Allocation tidak diatur ulang setiap kali input income; ia hanya diubah jika user masuk ke halaman pengaturan.

🧱 Virtual Fund System (Dompet Digital Internal)

Setiap kategori alokasi atau fund buatan user akan muncul sebagai card/section di dashboard. Fund bersifat fleksibel dan dapat dibuat, diubah, atau dihapus oleh user.

Contoh fund:

Tabungan Motor

Dana Darurat

Investasi Saham

Liburan

Fund memiliki:

Saldo aktif

Riwayat transaksi

Penerimaan dana dari auto allocation

Input manual (tambah/kurangi saldo)

Fund adalah tempat uang “tinggal” secara sistem virtual.

🔁 Auto Allocation Engine

Ketika income dalam mode real diproses, sistem:

Mengambil allocation rule aktif

Menghitung nominal berdasarkan persentase

Menyalurkan nominal ke fund yang sesuai

Mencatat history di masing-masing fund

Menampilkan ringkasan hasil pembagian (success modal)

Jika mode simulation dipilih, sistem hanya menghitung dan menampilkan hasil tanpa mengubah fund.

📜 Fund History & Transparency

Setiap fund memiliki histori transaksi yang mencatat:

Tanggal

Sumber (Income tertentu / Manual adjustment)

Nominal

Tipe (auto allocation / manual)

Catatan opsional

Hal ini memastikan transparansi dan audit personal bagi user.

📊 Grafik & Visualisasi

Dashboard memiliki grafik income dengan dua mode:

Daily View → menampilkan titik sesuai tanggal setiap pemasukan

Monthly View → menampilkan total income per bulan

Data disimpan berbasis tanggal aktual sehingga grafik dapat fleksibel tanpa mengubah struktur data.

Grafik bersifat dinamis dan akan langsung diperbarui setelah income diproses.

🧠 Filosofi Sistem

Aplikasi ini bukan sekadar expense tracker. Fokus utamanya adalah:

Membagi uang sejak awal

Memberi tujuan pada setiap pemasukan

Menciptakan disiplin finansial otomatis

Mengurangi beban berpikir user

Sistem dirancang untuk meminimalkan kompleksitas dan decision fatigue, dengan default behavior yang pintar dan otomatis, namun tetap menyediakan fleksibilitas melalui mode simulasi dan fund custom.

🎯 Visi Versi Awal (V1)

Versi pertama hanya mencakup:

Login system

Income event-based

Allocation setting

Auto allocation engine

Virtual fund system

Fund history

Dashboard + grafik 2 mode

Simulation mode

Tidak ada admin, tidak ada fitur sosial, tidak ada kompleksitas bisnis.

Fokus: sistem stabil, bersih, dan benar-benar membantu user mengatur aliran uangnya.
