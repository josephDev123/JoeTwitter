// //  send post from profile page to postFromProfile.php to submit post.
// $(document).ready(function(){

//     $('#sendpostfromProfile').on('click', ()=>{
      
//       $.ajax({
//         type:'POST',
//         url: "includes/postFromProfile.php",
//         data:{
//           text: $('#message_text').val(),
//           userTo: '<?php echo $username; ?>',
//           postBy:  "<?php echo $loggedIn; ?>"
//         },
 
//         success:(result)=>{
//          console.log(result);
//         },
 
//         success:(error)=>{
//          console.log(error);
//        }
 
//       })
//       location.reload();
 
//     })


//  })
 
function listOfUsersToMessage(){
    console.log('hello');
}