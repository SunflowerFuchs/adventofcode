package main

import (
	"fmt"
	"io/ioutil"
	"log"
	"strconv"
	"strings"
)

func run_1_2() {
	var content []byte
	var items []string
	var cnt int = 0
	var last int

	content, err := ioutil.ReadFile("input.txt")
	if err != nil {
		log.Fatal(err)
	}
	items = strings.Split(string(content), "\n")

	windows := make([]int, len(items)-2)
	for i, v := range items {
		cur, _ := strconv.Atoi(v)
		if i >= 2 {
			windows[i-2] += cur
		}
		if i >= 1 && i <= len(items)-2 {
			windows[i-1] += cur
		}
		if i <= len(items)-3 {
			windows[i] += cur
		}
	}

	for _, v := range windows {
		if v > last && last != 0 {
			cnt++
		}

		last = v
	}

	fmt.Println(cnt)
}
