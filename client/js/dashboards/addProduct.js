const addBtn = document.getElementById("add-product-btn");
const productNameEl = document.getElementById("product-name");
const productQuantityEl = document.getElementById("product-quantity");
const productUnitPriceEl = document.getElementById("product-unit-price");
const productCostPriceEl = document.getElementById("product-cost-price");
const productSellingPriceEl = document.getElementById("product-selling-price");
const productImageEl = document.getElementById("product-image");

addBtn.addEventListener("click", async () => {
  if (
    !productNameEl.value ||
    !productQuantityEl.value ||
    !productUnitPriceEl.value ||
    !productCostPriceEl.value ||
    !productSellingPriceEl.value 
    
  ) {

    return alert("all feilds are mandatory");
  }
  const formData = new FormData();
  
  
  const productImage = productImageEl.files[0];

  formData.append('productName',productNameEl.value)
  formData.append('productQuantity',productQuantityEl.value)
  formData.append('productUnitPrice',productUnitPriceEl.value)
  formData.append('productCost',productCostPriceEl.value)
  formData.append('productSellingPrice',productSellingPriceEl.value)

  if (productImage) {
    formData.append('productImage', productImage);
  }

  try {
    const res = await fetch("../../../server/controllers/dashboards/addProductController.php",{
        method:"POST",
        body:formData
    })

    if(!res.success){
        return alert(res.message);
    }
    const data = await res.json();
    alert(data.message)
  } catch (err) {
    console.error("something went wrong",err);
    alert('something went wrong')
  }
});
