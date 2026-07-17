const time = document.getElementById('date');

let hours=new Date().getHours();
let minutes=new Date().getMinutes()
let seconds=new Date().getSeconds()


setInterval(()=>{
    
 hours=new Date().getHours();
 minutes=new Date().getMinutes()
 seconds=new Date().getSeconds()
 let meridian = 'AM '
if(hours >11){
    meridian = 'PM'
}

if(hours < 10 ){
    minutes = '0' + minutes;
   

}
if( minutes <10 ){
    minutes = '0' + minutes;
   

}
if( seconds<10){
   
    seconds = '0'+seconds

}
 time.innerHTML=`${hours}: ${minutes}: ${seconds} ${meridian}`

}, 1000)