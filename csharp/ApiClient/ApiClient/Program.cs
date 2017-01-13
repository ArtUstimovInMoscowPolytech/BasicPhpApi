using System;
using System.Collections.Generic;
using System.Threading.Tasks;
using Newtonsoft.Json;

namespace ApiClient
{
	class MainClass
	{
		public static void Main(string[] args)
		{
			Task.Factory.StartNew(async () =>
			{
				var ds = DataService.GetInstance();

				Console.WriteLine("*** Starting auth request ***");
				var authResponse = await ds.LoginAsync("User1", "Password1");
				Console.WriteLine(authResponse);
				Console.WriteLine();

				Console.WriteLine("*** Starting orders request ***");
				var ordersResponse = await ds.GetOrdersAsync();
				Console.WriteLine(ordersResponse);
				Console.WriteLine();

				Console.WriteLine("*** Product names ***");
				var orders = JsonConvert.DeserializeObject<List<Order>>(ordersResponse);
				foreach (var order in orders)
				{
					Console.WriteLine(order.Product);
				}
				Console.WriteLine();

				Console.WriteLine("*** Starting logout request ***");
				var logoutResponse = await ds.LogoutAsync();
				Console.WriteLine(logoutResponse);

			}).Wait();

			Console.Read();
		}
	}
}
