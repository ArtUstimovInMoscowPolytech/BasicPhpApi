using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Threading.Tasks;
using Newtonsoft.Json.Linq;

namespace ApiClient
{
	public class DataService
	{
		private static DataService _instance = new DataService();
		private HttpClient _client = new HttpClient();
		private string _baseUrl = "SET_YOUR_SERVER_ADDRESS_HERE";

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

				// Если нужно отправить как содержимое формы
				//var content = new FormUrlEncodedContent(new[] { new KeyValuePair<string, string>("data", json) });
				//var response = await _client.PostAsync($"{_baseUrl}/{script}", content);

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
