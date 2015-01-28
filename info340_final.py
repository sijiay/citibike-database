################################################################
##### Intro stuff, opening/reading files, connecting to server
#####sttp://codepen.io/tutorialab/pen/EJAet
################################################################

# import the postgres module
import psycopg2 
import csv
# Connect to an existing database
conn = psycopg2.connect("dbname=sijiay user=sijiay password=passcode")

# Open a cursor to perform database operations
cur = conn.cursor()


# Opens csv file
csvfile = open('citibike_august2014.csv', 'rU')
data = csv.DictReader(csvfile,delimiter=',') 
cur.execute("DROP TABLE trip")
cur.execute("DROP TABLE station")
cur.execute("DROP TABLE street_name")
#cur.execute("DROP TABLE user_type")
#cur.execute("DROP TABLE gender")


#Creates tables(stations, bikes, trips, streets, usertype)
cur.execute("CREATE TABLE street_name (id serial PRIMARY KEY, name varchar(30));")
cur.execute("CREATE TABLE station (station_id integer PRIMARY KEY, name varchar(50),street1_id integer REFERENCES street_name (id), street2_id integer REFERENCES street_name (id),lat varchar, long varchar);")
#cur.execute("CREATE TABLE user_type (id integer PRIMARY KEY, name varchar(15));")
#cur.execute("CREATE TABLE gender(id integer PRIMARY KEY, type varchar(10));")
cur.execute("CREATE TABLE trip (id serial PRIMARY KEY, start_station integer REFERENCES station(station_id), end_station integer REFERENCES station(station_id), start_time varchar, end_time varchar, duration integer, gender integer REFERENCES gender(id), user_type integer REFERENCES user_type(id), bikeid integer, birthyear varchar(4));")

try:
    cur.execute("""CREATE OR REPLACE FUNCTION insertSt(st varchar) 
        RETURNS integer AS $$
            DECLARE tmp int;
            BEGIN
                SELECT INTO tmp id FROM street_name WHERE name = st;
                IF tmp IS NULL THEN
                    INSERT INTO street_name (name) VALUES (st);
                    SELECT INTO tmp id FROM street_name WHERE name = st;
                END IF;
                RETURN tmp;
            END;
        $$ LANGUAGE plpgsql;""")
except psycopg2.Error, e:
    print e.pgerror

try:
    cur.execute("""CREATE OR REPLACE FUNCTION insertStation(s_id integer, name varchar, lat varchar, long varchar, s1_id integer, s2_id integer) 
        RETURNS integer AS $$
            DECLARE tmp int;
            BEGIN
                SELECT INTO tmp station_id FROM station WHERE station_id = s_id;
                IF tmp IS NULL THEN
                    INSERT INTO station(station_id, name,  lat, long, street1_id, street2_id) VALUES (s_id, name, lat, long, s1_id, s2_id);
                END IF;
                RETURN tmp;
            END;
        $$ LANGUAGE plpgsql;""")
except psycopg2.Error, e:
    print e.pgerror


print data.fieldnames

def addStreets(station_name):
    # print(station_name)
    temp = station_name.split('&')
    ids = []
    for st in temp:
        # print(st)
        cur.execute("SELECT insertSt(%s)", (st.strip(),))
        temp_id= cur.fetchone()
        ids.append(temp_id)
    if len(temp) == 1:
        ids.append(None)
    return ids



def populateTables():
	for line in data:
		
        #adds streets to the street table and saves inputed street ids
		start_ids = addStreets(line['start_station_name'])
		end_ids = addStreets(line['end_station_name'])
		# print(start_ids)
		# print(end_ids)
		#adds stations to the station table
		cur.execute("SELECT insertStation(%s, %s, %s, %s, %s, %s)",(line['start_station_id'],line['start_station_name'],line['start_station_latitude'],line['start_station_longitude'],start_ids[0], start_ids[1]))
		cur.execute("SELECT insertStation(%s, %s, %s, %s, %s, %s)",(line['end_station_id'],line['end_station_name'],line['end_station_latitude'],line['end_station_longitude'], end_ids[0], end_ids[1]))
		
		if(line['usertype'] == 'Subscriber'):
			ut = 0
		if(line['usertype'] == 'Customer'):
			ut = 1

		cur.execute("INSERT INTO trip (start_station , end_station, start_time, end_time, duration, gender, user_type, bikeid, birthyear) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",(line['start_station_id'], line['end_station_id'], line['starttime'], line['stoptime'], line['tripduration'], line['gender'], ut, line['bikeid'], line['birth_year']))
	print 'finished'

populateTables()



	


# Make the changes to the database persistent
conn.commit()
# Close communication with the database
cur.close()
conn.close()