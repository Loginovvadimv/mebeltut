
document.addEventListener('DOMContentLoaded', () => {
  const vk_button = document.querySelector('#vk-button')

  if (!vk_button) {
    return
  }

  vk_button.addEventListener('click', async (e) => {
    e.preventDefault();

    const body = new FormData();
    body.append('post_id',window.vk_post_id)
    let response = await fetch('/wp-json/site/v1/vk/post', {
      method: 'POST',
      body: body
    })

    response = await response.json()
    if(response.success){
      alert('Пост опубликован')
    }else {
      alert('Пост не опубликован(произошла ошибка)')
    }

  })
})



