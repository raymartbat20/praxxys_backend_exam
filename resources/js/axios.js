import axios from 'axios'


const token = localStorage.getItem('token');
const instance = axios.create({
    baseURL: 'http://localhost:8000/api/',
    headers: {
        "Content-type": "application/json",
        "Accept": "application/json",
        "Authorization": `Bearer ${token}`
    }
});

export default instance