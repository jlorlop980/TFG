import { environment } from "../environments/enviroments"
import axios, { AxiosInstance, AxiosResponse } from 'axios';


export class apiService {
    private api: AxiosInstance;
    private token: string = '';

    constructor() {
      this.api = axios.create({
        baseURL: environment.API_URL,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
      });
      this.setToken();
    }


/**
 * token related
 */
    public getToken() {
        this.token = localStorage.getItem('token') || '';
    }
  
    public setToken() {
        this.getToken();
      this.api.defaults.headers.common.Authorization = `Bearer ${this.token}`;
    }
  

/**
 * user calls
 */
    public async login(mail: string, password: string): Promise<AxiosResponse<any>> {
        return this.api.post('/login', {
            mail,
            password,
        });
    }

    public async register(name: string, mail: string, password: string): Promise<AxiosResponse<any>> {
        return this.api.post('/register', {
            name,
            mail,
            password,
        });
    }

    public async logOut(): Promise<AxiosResponse<any>> {
        return this.api.get('/logout');
    }


/**
 * favorites calls
 */
    public async getAllFavorites(token: string): Promise<AxiosResponse<any>> {
        this.setToken();
        return this.api.get('/favorites');
    }


/**
 * search calls
 */
    public async getAllSongs(): Promise<AxiosResponse<any>> {
        return this.api.get('/songs');
      }


/**
 * playlist calls
 */
      public async getallPublicPlaylists(): Promise<AxiosResponse<any>> {
        return this.api.get('/playlists/public');
      }


      public async getAllUserPlaylists(): Promise<AxiosResponse<any>> {
        this.setToken();
        return this.api.get('/playlists');
      }

/**
 * genre calls
 */
    public async getAllGenres(): Promise<AxiosResponse<any>> {
        return this.api.get('/genres');
    }


/**
 * artist calls
 */
    public async getAllArtists(): Promise<AxiosResponse<any>> {
        return this.api.get('/artists');
    }


//fin de clase
}