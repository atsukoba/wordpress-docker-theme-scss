# WordPress Theme Starter

## setup

```shell=
npm i
```

## dev

```shell=
gulp watch
```

## local WordPress

```shell=
docker-compose up -d
```

db > dump

```shell=
mysqldump -u admin -p pass -P 3306 -h 127.0.0.1 -r dump.sql --single-transaction wordpress
```

dump > db

```shell=
mysqldump -u admin -p pass -P 3306 -h 127.0.0.1 < dump.sql
```

## design

- breakpoints

```sass=
@include breakpoints((
    xlarge:   ( 1281px,  1920px ),
    large:    ( 981px,   1280px ),
    medium:   ( 737px,   980px  ),
    small:    ( 481px,   736px  ),
    xsmall:   ( 361px,   480px  ),
    xxsmall:  ( null,    360px  )
));
```

- how to include in scss

```sass=
@include breakpoint('large') {
    hogehoge: hogehoge;
}

@include breakpoint('<=large') {
    hogehoge: hogehoge;
}

@include breakpoint('>=large') {
    hogehoge: hogehoge;
}

@include breakpoint('<large') {
    hogehoge: hogehoge;
}

@include breakpoint('>large') {
    hogehoge: hogehoge;
}

@include breakpoint('!=large') {
    hogehoge: hogehoge;
}
```
