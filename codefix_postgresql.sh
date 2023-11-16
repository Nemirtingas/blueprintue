grep 'UTC_TIMESTAMP()' -Ri . | awk -F: '{ print $1 }' | while read f; do sed -i "s|UTC_TIMESTAMP()|timezone('utc', now())|i" "$f"; done
grep 'LIMIT :offset, :count' -Ri . | awk -F: '{ print $1 }' | while read f; do sed -i 's/LIMIT :offset, :count/LIMIT :count OFFSET :offset/i' "$f"; done
