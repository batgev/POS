document.getElementById('btn').addEventListener('click',async(e)=>{
    e.preventDefault();

    try {
        const res = await fetch('/POS/server/controllers/auth/logoutController.php',
        {method:'POST'
    });
    const data = await res.json();

    if(data.success){
        alert("logged out")
        setTimeout(()=>{
            window.location.href = '/POS/client/auth/login.php'
        },1000)
    }
    } catch (error) {
        alert('logout failed' ,error)
    }
})
