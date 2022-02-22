# Monitoring introduction dva

## How to

**Optional** - repository contains `prepare-server.sh` script which can set up fresh server. (Tested on Ubuntu 20.04.3).
It basically installs useful command tools, docker and create some aliases.

Then you can start whole docker-compose stack. It takes some time, no worries! More CPU = more speed!

```
git clone git@github.com:kozaktomas/talk-monitoring.git monitoring-demo
# or scp all file somewhere ... somehow
cd monitoring-demo/2022-02-23/
make run
```

### Running services (exposed ports)

| Service name            | Port |
|-------------------------|------|
| Grafana                 | 3000 |
| Prometheus              | 9090 |
| Testing web app (nginx) | 8080 |
| Redis exporter          | 9121 |
| PHP exporter            | 9253 |
| Nginx exporter          | 9113 |
| AWS exporter            | 9383 |
| Domains exporter        | 9203 |
| Node exporter           | 9203 |

### Generate load (DOS attack)
```bash
ab -n 50000000 -c 40 http://demo:8080/
````

### Redis status

```bash
docker-compose exec redis bash  # host
redis-cli                       # redis container
INFO ALL                        # redis command line tool
# keyspace_hits:7079
# keyspace_misses:7688
```

### PHP-FPM status

```bash
export SCRIPT_NAME=/status; \
export SCRIPT_FILENAME=/status; \
export REQUEST_METHOD=GET; \
cgi-fcgi -bind -connect /root/php/data/sock/php.sock
```

### Domain expiration
```bash
whois alza.cz
```

## Might be useful:

- Metric type - https://prometheus.io/docs/concepts/metric_types/
- Exporters - https://prometheus.io/docs/instrumenting/exporters/
- Exporter ports - https://github.com/prometheus/prometheus/wiki/Default-port-allocations
- SRE books - https://sre.google/books/
- Slides - https://docs.google.com/presentation/d/1_FTfBtyzcm5hxVdz8siDJdlTMu8yg2u2Ou-DLhScSP4/edit?usp=sharing

## Exporters and tools:

- Redis exporter - https://github.com/oliver006/redis_exporter
- Domains exporter - https://github.com/kozaktomas/domain_exporter
- AWS exporter - https://github.com/Jimdo/aws-health-exporter
- Nginx exporter - https://github.com/nginxinc/nginx-prometheus-exporter
- PHP-FPM exporter - https://github.com/hipages/php-fpm_exporter
- Node exporter - https://github.com/prometheus/node_exporter
- PHP-FPM healthcheck - https://github.com/renatomefi/php-fpm-healthcheck

## Kudos

- Martin Chodur @fusakla
