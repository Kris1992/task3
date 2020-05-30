# How to run

Make sure you have csv file in public directory. <br />
Go to console and run following command: <br />

```
php bin/console app:csv:validate [filename with extension]
```

To run command in fast mode (without additional validators):<br />

```
php bin/console app:csv:validate [filename with extension] --highPrecision=false

```
