const keranjang = document.querySelector('.keranjang');
const detail = document.querySelector('.kr');

keranjang.addEventListener('click', function() {
		detail.classList.toggle('detail');
		detail.classList.toggle('detail_kr');
});