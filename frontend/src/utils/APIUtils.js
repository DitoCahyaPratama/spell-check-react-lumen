import { API_BASE_URL } from '../constants';
import axios from 'axios'

const api = axios.create({
    baseURL: API_BASE_URL
})

export const cekKata = async (option) => {
    try {
        let res = await api.post('/cekkata', {kalimat: option})
        return res;
    } catch (err) {   
        return err
    }
}