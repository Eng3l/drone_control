# Drone delivery system

## Main functions

Relation of actions and its endpoints.

| Action                                             | Method | Endpoint                     |
|----------------------------------------------------|--------|------------------------------|
| Registering a drone                                | POST   | /api/drones                  |
| Loading a drone with medication items              | POST   | /api/drones/{serial}/load    |
| Checking loaded medication items for a given drone | GET    | /api/drones/{serial}/load    |
| Checking available drones for loading              | GET    | ​/api​/drones​/availables       |
| Check drone battery level for a given drone        | GET    | /api/drones/{serial}/battery |
| Check drones battery                               | POST   | /api/battery_logs            |
| List history of drone battery checks               | GET    | /api/battery_logs            |
| Register a medication                              | POST*  | /api/medications             |

* Body request should be as a *multipart/form-data*.

Documentatation of all endpoints can be found at `/api`.

## Assumptions 

* A drone is created in IDLE status.
* A drone can't be loaded if it's state is not IDLE or LOADING.
* The state of a drone can't be set to LOADED if is not in
LOADING state or is empty.
* The state of a drone can't be set to DELIVERING if is not in
 LOADED state.
* The state of a drone can't be set to DELIVERED if it was not
DELIVERING.
* The state of a drone can't be set to RETURNING if it was not
DELIVERED or DELIVERING.
* The state of a drone only can be setted to IDLE if is LOADING,
LOADED or RETURNING. In all cases the load will be removed.

## Run the system

To run the system it can be done with `docker` and `docker-compose`.
Just go to docker folder and run the system.

```bash
cd docker
docker-compose up -d
```

The system is loaded with predefined data (states and model), drones
and medications must be created using endpoint described above.