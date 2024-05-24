const message = (msg) => {
    const message = document.querySelector('.copy-message');
    message.textContent = msg;
    message.classList.remove('hidden');
    message.classList.add('shown');

    setTimeout(() => {
        message.classList.remove('shown');
        message.classList.add('hidden');
    }, 2000);
}

function copyToClipboard(text) {
    const input = document.createElement('input');
    input.value = text;
    document.body.appendChild(input);
    input.select();
    document.execCommand('copy');
    document.body.removeChild(input);

    message('تم نسخ الي الحافظة');
}
