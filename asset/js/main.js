// $(document).ready(()=>{
    // $.post(searchResult.php, {query:$input_value, personLoggedIn:$userloggedIn}, (data)=>{
    //     $('.search_result').html(data);

    // })    

//     console.log('hello');
// })
    // let input = document.getElementById('search_input_text');
    // input.onclick = fetchResult('<?php echo $userloggedIn; ?>');
        function fetchResult(value, userloggedIn){
                fetch(`searchResult.php`, {
                    method:'POST',
                    headers: {
                        'Content-Type': 'application/json'
                        // 'Content-Type': 'application/x-www-form-urlencoded',
                      },
                      mode: "same-origin",
                      credentials: "same-origin",
                    body:{
                        query:JSON.stringify(value),
                        personLoggedIn:JSON.stringify(userloggedIn)
                    }
                    
                }).then(data =>{
                        // document.querySelector('.search_result').innerHTML = data.json();
                        console.log(data.text());
                }).then(response =>{
                    console.log('success;',response);
                }).catch(error=>{
                    document.querySelector('.search_result').innerHTML = error.message;
                })
        }
