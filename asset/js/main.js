// $(document).ready(()=>{
//     function fetchResult(value, userloggedIn){
//     $.post('searchResult.php', {'query':value, 'personLoggedIn':userloggedIn}, (data)=>{
//         // $('.search_result').html(data);
//     console.log(data);
//     })    
//     }
// })
  // })
    // let input = document.getElementById('search_input_text');
    // input.onclick = fetchResult('<?php echo $userloggedIn; ?>');
        function fetchResult(value, userloggedIn){
            let data = {
                query:JSON.stringify(value),
                personLoggedIn:JSON.stringify(userloggedIn)
            }
                fetch('searchResult.php', {
                    headers: {
                        'Content-Type': 'application/json'
                      },
                    method:'POST',
                      mode: "same-origin",
                      credentials: "same-origin",
                    body:JSON.stringify(data)
                    
                }).then(res =>res.text())
                .then(response =>{
                    console.log(response);
                    document.querySelector('.search_result').innerHTML = response;
                }).catch(error=>{
                    console.log(error.message);
                    document.querySelector('.search_result').innerHTML = error.message;
                })
            }
