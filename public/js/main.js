/*=============== MOSTRAR/OCULTAR SENHA - LOGIN ===============*/
const passwordAccess = (loginPass, loginEye) => {
    const input   = document.getElementById(loginPass),
          iconEye = document.getElementById(loginEye)

    if (!input || !iconEye) return

    iconEye.addEventListener('click', () => {
        // Alterna entre senha e texto
        input.type === 'password' ? input.type = 'text'
                                  : input.type = 'password'

        // Troca o ícone
        iconEye.classList.toggle('ri-eye-fill')
        iconEye.classList.toggle('ri-eye-off-fill')
    })
}
passwordAccess('password', 'loginPassword')

/*=============== MOSTRAR/OCULTAR SENHA - CADASTRO ===============*/
const passwordRegister = (loginPass, loginEye) => {
    const input   = document.getElementById(loginPass),
          iconEye = document.getElementById(loginEye)

    if (!input || !iconEye) return

    iconEye.addEventListener('click', () => {
        // Alterna entre senha e texto
        input.type === 'password' ? input.type = 'text'
                                  : input.type = 'password'

        // Troca o ícone
        iconEye.classList.toggle('ri-eye-fill')
        iconEye.classList.toggle('ri-eye-off-fill')
    })
}
passwordRegister('passwordCadastro', 'loginPasswordCreate')