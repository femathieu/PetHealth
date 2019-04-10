export class AppConfig {
    private apiBaseUrl: string = 'http://localhost';

    public get getApiBaseUrl() : string {
        return this.apiBaseUrl;
    }
    
}