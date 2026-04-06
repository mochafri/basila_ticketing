import { reject, escalated, approveTiket } from "./app.js";

document.addEventListener('DOMContentLoaded', () => {
    const segments = window.location.pathname.split('/');
    const slug = segments.pop();
    const parseSlug = parseInt(slug);

    // Button reject tiket nya
    document.querySelector('.btn-reject').addEventListener('click', async () => {
        await reject(parseSlug);
    });

    // Button eskalasi tiket nya
    document.querySelector('.btn-escalated').addEventListener('click', async () => {
        await escalated(parseSlug);
    });

    document.querySelector('.btn-approve').addEventListener('click', async () => {
        console.log('click');
        const selected = document.querySelector('input[name="user_id[]"]:checked');

        if (!selected) {
            alert('Pilih kabag dulu');
            return;
        }

        const kabag = selected.value;
        const label = selected.closest('label');
        const namaKabag = label.querySelector('span').innerText;

        await approveTiket(parseSlug, kabag, namaKabag);
    });
});