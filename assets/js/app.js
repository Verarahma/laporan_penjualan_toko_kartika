function addItem(){
  const sel = document.getElementById('product_select');
  const qtyInput = document.getElementById('qty');
  if(!sel.value) return;
  const [id,kode,nama,harga] = sel.value.split('|');
  const qty = parseInt(qtyInput.value)||1;
  const tbody = document.getElementById('items_body');
  const tr = document.createElement('tr');
  tr.innerHTML = `
    <td>${kode}</td>
    <td>${nama}</td>
    <td><input type="number" name="qty[]" value="${qty}" min="1" onchange="recalc()"></td>
    <td><input type="hidden" name="id_product[]" value="${id}">${(harga*qty).toFixed(2)}</td>
    <td><button type="button" onclick="this.parentElement.parentElement.remove();recalc()">Hapus</button></td>
  `;
  tbody.appendChild(tr);
  recalc();
}
function recalc(){
  // total dihitung server-side, fungsi ini untuk update UI jika mau dikembangkan
}
