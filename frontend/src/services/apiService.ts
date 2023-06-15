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
    public getToken() : string{
        this.token = localStorage.getItem('token') || '';
        return this.token;
    }
  
    public setToken() {
        this.getToken();
        this.api.defaults.headers.common.Authorization = `Bearer ${this.token}`;
    }
    public removeToken() {
        this.token = '';
        localStorage.removeItem('token');
        this.api.defaults.headers.common.Authorization = '';
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
        this.setToken();
        return this.api.get('/logout');
    }


/**
 * favorites calls
 */
    public async getAllFavorites(token: string): Promise<AxiosResponse<any>> {
        this.setToken();
        return this.api.get('/favorites');
    }

    public async deleteFavorite(id: number): Promise<AxiosResponse<any>> {
        this.setToken();
        return this.api.delete(`/favorite/${id}`);
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
    public async getAllPlaylists(): Promise<AxiosResponse<any>> {
        this.setToken();
        return this.api.get('/playlists');
    }

    public async createPlaylist(name: string): Promise<AxiosResponse<any>> {
        this.setToken();
        return this.api.post('/playlist', {
            name,
        });
    }

    public async deletePlaylist(id: number): Promise<AxiosResponse<any>> {
        this.setToken();
        return this.api.delete(`/playlist/${id}`);
    }

    public async deleteSongFromPlaylist(playlistId: number, id_song: number): Promise<AxiosResponse<any>> {
        this.setToken();
        return this.api.delete(`/playlist/${playlistId}/song/`, {
            data:{id_song}
            });
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