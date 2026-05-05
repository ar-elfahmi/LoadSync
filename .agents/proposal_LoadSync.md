

***Intelligent Energy Management System*** **Berbasis Web dengan Algoritma *Load-Shedding* untuk Optimalisasi Pembangkit Listrik Tenaga Surya pada Industri Menengah**

Disurun Untuk memenuhi Seleksi Abstrak dari Hackaton IYREF2026

Oleh Tim **Nasihat Jawa**, dengan anggota :  
Nabil Hakim Alfikri  
Andhika Muhammad Iqbal  
Alfian Rasyid El Fahmi  
**A. Latar Belakang & Problem Statement**  
Transisi menuju energi terbarukan menjadi agenda global dalam menghadapi krisis iklim dan peningkatan emisi karbon. Salah satu sumber energi terbarukan yang banyak diadopsi adalah panel surya (Photovoltaic/PV). Namun, karakteristik utama energi PV yang bersifat intermiten—bergantung pada kondisi cuaca—menjadi tantangan signifikan dalam penerapannya, khususnya pada sektor industri yang membutuhkan kestabilan pasokan energi (Lu et al., 2025).

Fluktuasi daya akibat perubahan cuaca secara cepat dapat menyebabkan ketidakseimbangan antara suplai dan kebutuhan energi. Dampak yang ditimbulkan antara lain penurunan efisiensi operasional mesin, potensi downtime produksi, hingga kerugian ekonomi akibat gangguan proses industri. Permasalahan ini semakin kompleks bagi industri menengah yang mulai mengadopsi energi surya, namun belum memiliki sistem manajemen energi yang adaptif dan terjangkau (Sabki et al., 2025).

Saat ini, solusi seperti Supervisory Control and Data Acquisition (SCADA) telah digunakan untuk mengelola sistem energi industri. Namun, implementasi SCADA cenderung memerlukan biaya tinggi, integrasi perangkat keras yang kompleks, serta sumber daya manusia dengan keahlian khusus. Hal ini menjadikan solusi tersebut kurang relevan bagi industri skala menengah (Phuyal et al., 2020).

Oleh karena itu, diperlukan suatu sistem yang mampu mengelola fluktuasi energi PV secara cerdas, adaptif, dan terjangkau, guna memastikan kestabilan suplai energi sekaligus meningkatkan efisiensi penggunaan energi terbarukan.

**B. Pendekatan Sistem yang Dirancang**  
Solusi yang diusulkan adalah pengembangan Intelligent Energy Management System (IEMS) berbasis web yang berfungsi sebagai sistem add-on untuk mengoptimalkan pemanfaatan energi panel surya pada industri menengah.

Sistem ini dirancang untuk bekerja secara terintegrasi dengan alur energi sebagai berikut: energi yang dihasilkan oleh panel surya disalurkan ke baterai penyimpanan, kemudian dikelola oleh sistem sebelum didistribusikan ke mesin industri. IEMS akan berperan sebagai pusat pengambilan keputusan berbasis data dalam mengatur distribusi energi tersebut.

Fitur utama sistem meliputi:

1. Monitoring Energi Real-time: Sistem memantau input dan output energi secara langsung, termasuk produksi energi dari panel surya, kapasitas baterai, serta konsumsi energi oleh mesin industri.  
2. Forecasting Berbasis Data Cuaca: Integrasi dengan API prakiraan cuaca digunakan untuk memprediksi potensi produksi energi PV dalam jangka pendek. Informasi ini menjadi dasar dalam perencanaan penggunaan energi.  
3. Decision Support System (DSS): Sistem memberikan rekomendasi atau melakukan otomatisasi dalam pengalihan sumber energi (misalnya dari PV ke PLN) berdasarkan kondisi suplai dan kebutuhan energi.  
4. Manajemen Operasional Mesin: Sistem mampu mengatur aktivasi atau penonaktifan mesin industri secara selektif untuk menghindari overload atau kekurangan daya.  
5. Notifikasi dan Mitigasi Risiko: Pengguna akan menerima peringatan dini terkait potensi penurunan suplai energi, sehingga dapat mengambil langkah preventif secara cepat.

Pendekatan ini menempatkan sistem tidak hanya sebagai alat monitoring, tetapi sebagai sistem pengambilan keputusan cerdas yang mampu meningkatkan efisiensi dan stabilitas operasional.

**C. Justifikasi Keberadaan Sistem & Target Pengguna**  
Keberadaan sistem ini didasarkan pada kebutuhan industri menengah akan solusi manajemen energi yang lebih sederhana, fleksibel, dan ekonomis dibandingkan sistem konvensional seperti SCADA. Dengan pendekatan berbasis web dan arsitektur modular, sistem ini dapat diimplementasikan tanpa memerlukan perubahan besar pada infrastruktur yang sudah ada.

Nilai utama yang ditawarkan oleh sistem ini adalah:

1. Aksesibilitas Tinggi: Tidak memerlukan perangkat keras kompleks  
2. Efisiensi Biaya: Lebih terjangkau bagi industri menengah  
3. Adaptif dan Prediktif: Menggunakan data cuaca untuk pengambilan keputusan  
4. Modularitas: Dapat diintegrasikan sebagai add-on system

Target pengguna utama dari sistem ini adalah industri menengah yang telah atau sedang mengadopsi panel surya sebagai sumber energi alternatif, namun belum memiliki sistem manajemen energi yang optimal.

Dari sisi kontribusi terhadap keberlanjutan, sistem ini mendukung peningkatan pemanfaatan energi terbarukan secara lebih efisien dan stabil. Dengan mengurangi ketergantungan terhadap sumber energi konvensional, sistem ini berkontribusi pada penurunan emisi karbon dan mendukung agenda transisi energi bersih.

Dalam jangka panjang, implementasi sistem ini berpotensi:

1. meningkatkan kepercayaan industri terhadap energi terbarukan  
2. mempercepat adopsi teknologi hijau di sektor industri  
3. menciptakan ekosistem industri yang lebih berkelanjutan

Dengan demikian, sistem yang diusulkan tidak hanya menyelesaikan permasalahan teknis terkait fluktuasi energi, tetapi juga memberikan dampak strategis dalam mendukung transformasi menuju industri hijau yang berkelanjutan.

**Referensi:**  
Lu, B., Thomson, C. J., Wang, S., Rahbari, A., McArthur, L., Liu, A., & Pye, J. (2025).  
Decarbonising heavy industry operations with low-cost onsite photovoltaics and battery  
storage. Solar Energy, 303, 114104\. https://doi.org/10.1016/j.solener.2025.114104  
Phuyal, S., Bista, D., Iżykowski, J., & Bista, R. (2020). Design and Implementation of Cost  
Efficient SCADA System for Industrial Automation. International Journal of Engineering  
and Manufacturing, 10(2), 15\. https://doi.org/10.5815/ijem.2020.02.02  
Sabki, S. A., Hishamuddin, H., Sabtu, M. I., & Wahid, Z. (2025). Aplikasi Tenaga Solar dalam  
Industri Pembuatan Malaysia: Analisis Cabaran dan Faktor Kejayaan. Jurnal Kejuruteraan 37(1), 49\. https://doi.org/10.17576/jkukm-2025-37(1)-05