using System;
using System.Net.Http;
using System.Threading.Tasks;
using Newtonsoft.Json.Linq;

namespace ApiClient
{
	public class DataService
	{
		private static DataService _instance = new DataService();
		private HttpClient _client = new HttpClient();
		private string _baseUrl = "http://ppa.localhost/php";

		protected DataService()
		{
			
		}

		public static DataService GetInstance()
		{
			return _instance;
		}

		public async Task<string> LoginAsync(string userName, string password)
		{
			var json = new JObject { { "UserName", userName }, { "Password", password } };
			return await PostAsync("auth.php", json.ToString());
		}

		public async Task<string> LogoutAsync()
		{
			return await PostAsync("logout.php", string.Empty);
		}

		private async Task<string> PostAsync(string script, string json)
		{
			try
			{	
				var response = await _client.PostAsync($"{_baseUrl}/{script}", new StringContent(json));
				return await response.Content.ReadAsStringAsync();
			}
			catch (Exception e)
			{
				return e.Message;
			}
		}

		public async Task<string> GetOrdersAsync()
		{
			try
			{
				return await _client.GetStringAsync($"{_baseUrl}/orders.php");
			}
			catch (Exception e)
			{
				return e.Message;
			}
		}
	}
}
