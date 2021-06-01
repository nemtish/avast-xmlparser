# Avast Task

Please prepare a simple PHP app for exporting data from the attached XML file to Redis.
The app needs to be done the way we can run it in a cloud environment.
You have the freedom to choose if you will use any framework or you will write it in vanilla PHP.
Please focus on simplicity, proper logic, and tests.

## Task description

- From attached XML file, please export data to Redis,
- key "subdomains" will contain JSON with all subdomains (e.g. ["http://secureline.tools.avast.com", "http://gf.tools.avast.com"]),
- keys "cookie:%NAME%:%HOST%" will contain values of cookie elements (e.g. key "cookie:dlp-avast:amazon" will contain string "mmm_amz_dlp_777_ppc_m"),
- use docker-compose for setting up cloud environment (PHP and Redis needs to have their own containers),
- please use PHPUnit for tests.
- to run the app please use this command:
	export.sh /path/to/xml 
- if "-v" argument is present in command it should print all keys saved to Redis
	export.sh -v /path/to/xml