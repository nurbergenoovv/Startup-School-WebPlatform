const bgofshop = document.querySelector("#bgofshop");
const shop = document.querySelector("#shop");
const openerr = document.querySelector("#openerr");

bgofshop.addEventListener("click", () => {
  shop.style.display = "none";
  bgofshop.style.display = "none";
});

function openWin() {
  console.log("clicked");
  shop.style.display = "flex";
  bgofshop.style.display = "flex";
}
