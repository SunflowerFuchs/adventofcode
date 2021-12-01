package main

import (
	"fmt"
	"io/ioutil"
	"log"
	"strconv"
	"strings"
)

func run_1_1() {
	var content []byte
	var items []string
	var cnt int = 0
	var last int

	content, err := ioutil.ReadFile("input.txt")
	if err != nil {
		log.Fatal(err)
	}
	items = strings.Split(string(content), "\n")

	for _, v := range items {
		cur, _ := strconv.Atoi(v)
		if cur > last && last != 0 {
			cnt++
		}

		last = cur
	}

	fmt.Println(cnt)
}
