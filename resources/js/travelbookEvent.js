$(function(){
    $('.btnpaytravel').click(function (e) {
        Swal.fire({
            title: 'Masukan DP yang di terima',
            input: 'email',
            inputAttributes: {
              autocapitalize: 'off',
              width:'100%'
            },
            showCancelButton: true,
            confirmButtonText: 'Submit DP',
            showLoaderOnConfirm: true,
            preConfirm: (login) => {
              return fetch(`//api.github.com/users/${login}`)
                .then(response => {
                  if (!response.ok) {
                    throw new Error(response.statusText)
                  }
                  return response.json()
                })
                .catch(error => {
                  Swal.showValidationMessage(
                    `Request failed: ${error}`
                  )
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: `${result.value.login}'s avatar`,
                imageUrl: result.value.avatar_url
              })
            }
          })
    })
});
